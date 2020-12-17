'use strict';

const Flexo = function(options){
    if(typeof options === 'string'){
        this.options.file = options;
        this.options.element = 'body';
    }else{
        this.options = options || {};
    }

    this.options.element = document.querySelector(this.options.element)
    this.folder = this.options.folder;

    if(window.location.hash !== undefined){
        var hash = window.location.hash;
        this.go({oldURL:'',newURL: hash})
    }

    window.addEventListener("hashchange", this.go, false)
    t=setTimeout(this.go,50); 
}

Flexo.prototype.load = function(url){
    const load = (url) => fetch(url).then(res=>res.text()).then( data => this.options.element.innerHTML = data.toString())
    return load(url)
}

Flexo.prototype.go = function(hash){
    if(window.location.hash != hash) { 
        hash = window.location.hash; 
    }
    if(hash.newURL === ''){
        hash = '!/home'
    }else{
        hash = window.location.hash;
        hash = hash.split('#')[1]
    }
    hash = hash.slice(2)
    console.log(this.folder+'/'+hash+'.php')
    return this.load(this.folder+'/'+hash+'.php')
}

const Bender = function(options){
    if(typeof options === 'string'){
        this.options.file = options;
        this.options.element = 'body';
    }else{
        this.options = options || {};
    }

    this.options.element = document.querySelector(options.element);

    return this.hashHandler();
}

Bender.prototype.go = function(){
    let url = location.hash.slice(3);
    if(url == ""){
        location.hash =  this.settings.home || "#!/home";
    }
    this.load(url);
}

Bender.prototype.load = function(url){
    url = this.options.folder+'/'+url+'.php';
    console.log(url);
    const load = (url) => fetch(url).then(res=>res.text())
    return load(url).then(
        data => this.element.innerHTML = data.toString()
    )
}

Bender.prototype.hashHandler = function(){
    this.oldHash = window.location.hash;
    this.Check;
    var that = this;
    var detect = function(){
        if(that.oldHash!=window.location.hash){
            that.oldHash = window.location.hash;
            that.go();
        }
    };
    this.Check = setInterval(function(){ detect() }, 100);
}


try {
    module.exports = exports = Bender;
}catch(e){
    'false';
}