const $ = function(element){
    return document.querySelector(element);
}


(function() {
    var foo = function(arg) { // core constructor
      // ensure to use the `new` operator
      if (!(this instanceof foo))
        return new foo(arg);
      // store an argument for this example
      this.myArg = arg;
      //..
    };
  
    // create `fn` alias to `prototype` property
    foo.fn = foo.prototype = {
      init: function () {/*...*/}
      //...
    };
  
    // expose the library
    window.foo = foo;
  })();
  
  // Extension:
  
  foo.fn.myPlugin = function () {
    alert(this.myArg);
    return this; // return `this` for chainability
  };
  
  foo("bar").myPlugin(); // alerts "bar"4


  fetch(url)
  .then(function(response){
      return response.blob();
  })
  .then(function(response){
      var data = URL.createObjectURL(response);
      fetch(data).then(response => response.text())
      .then(function (data) {
          return data;
      })
  })


  const request = async () => {
    let response = await fetch(url);
    response = await response.blob();
    response = await URL.createObjectURL(response);
    response = await fetch(response);
    response = await response.text();
    return response;
}


var $ = function(elem) {
    if (!(this instanceof $))
    return new $(elem);
    this.e = elem;
};  
$.fn = $.prototype = {

    init: function () {/*...*/}
};
$.fn.load = function (url) {

    console.log(this.e);
    document.querySelector(this.e).innerHtml = "ola";
}


    // separate function to make code more clear
    const grabContent = pages => fetch("pages/" + pages + ".html")
    .then(res => res.text())
    .then(html => (
        html.map();
    ))
    
    Promise.all(pages.map(grabContent)).then(() => console.log(`Urls ${pages} were grabbed`))
    
    })();
    


    const urls = [
      "https://jsonplaceholder.typicode.com/comments/1",
      "https://jsonplaceholder.typicode.com/comments/2",
      "https://jsonplaceholder.typicode.com/comments/3"
    ];
    
    async function fetchAll() {
      const results = await Promise.all(urls.map((url) => fetch(url).then((r) => r.json())));
      console.log(JSON.stringify(results, null, 2));
    }
    
    fetchAll();