<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Statements;


class StatementController extends AbstractController
{
    /**
     * @Route("/statement/{seo_path}", name="statement")
     */
    public function index($seo_path)
    {
        $repository = $this->getDoctrine()->getRepository(Statements::class);
        
        $statement = $repository->findOneBy(['seo_path' => $seo_path]);
        
        $stat_content = $statement->getContent();
        $pattern = '~\[id\](.*?)\[\/id\]~';
        preg_match_all($pattern, $stat_content, $matches);
        
        foreach($matches[1] as $key=>$match){
            $var_list[$key]['tip'] = 'tip';
            $var_list[$key]['key'] = $match;
        }        
        
        return $this->render('statement/index.html.twig', [
            'controller_name' => 'StatementController',
            'statement' => $statement,
            'var_list' => $var_list
        ]);
    }
    
    function getTextBetweenTags($tag, $html, $strict=0)
    {
        /*** a new dom object ***/
        $dom = new \domDocument;

        /*** load the html into the object ***/
        if($strict==1)
        {
            $dom->loadXML($html);
        }
        else
        {
            $dom->loadHTML($html);
        }

        /*** discard white space ***/
        $dom->preserveWhiteSpace = false;

        /*** the tag by its tag name ***/
        $content = $dom->getElementsByTagname($tag);

        /*** the array to return ***/
        $out = array();
        foreach ($content as $item)
        {
            /*** add node value to the out array ***/
            $out[] = $item->nodeValue;
        }
        /*** return the results ***/
        return $out;
    }
}
