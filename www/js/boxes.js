

Function.prototype.inheritsFrom = function( parentClassOrObject ){ 
    if ( parentClassOrObject.constructor == Function ) { 
        //Normal Inheritance 
        this.prototype = new parentClassOrObject;
        this.prototype.constructor = this;
        this.prototype.parent = parentClassOrObject.prototype;
    } else {
        //Pure Virtual Inheritance 
        this.prototype = parentClassOrObject;
        this.prototype.constructor = this;
        this.prototype.parent = parentClassOrObject;
    } 
    return this;
} 

function BoxController (domId) {
    
    this.boxId = domId;
    
    this.dataProvider = DataProvider();
    
    this.boxDom = $('#' + boxId);
    
    this.data = null;
    
    this.endpoint = null;
    
    this.getBoxId = function () {
        return this.boxId;
    }
    
    this.loadDataCallback = function () {
        
    }
    
    this.loadData = function () {
        this.data = null;
        this.dataProvider.setEndpoint(this.endpoint);
        this.dataProvider.setCallback(this.loadDataCallback);
        this.fetch();
    }
    
}

