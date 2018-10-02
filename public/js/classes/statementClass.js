class StatementClass {
    constructor(originalStatement) {
        this.originalStatement = originalStatement; 
        this.curentStatement = this.originalStatement;
    }
    getInput(statementVars) {
        this.curentStatement = this.replaceAll('[id]' + statementVars[0] + '[/id]', statementVars[1]);
    }    
    refresh() {
        CKEDITOR.instances['editor1'].setData(this.curentStatement);
        this.curentStatement = this.originalStatement;
    }
    replaceAll(search, replacement) {
        var target = this.curentStatement;
        return target.split(search).join(replacement);
    }
}