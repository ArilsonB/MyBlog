class MyBTextarea extends HTMLElement {
    constructor(){
        super();
        const shadow = this.attachShadow({ mode: 'open' })
        const editorStyle = document.createElement('link')
        editorStyle.rel = 'stylesheet'
        editorStyle.type = 'text/css'
        editorStyle.href = './editor.css'
        const wrapper = document.createElement('div')
        wrapper.id = 'myb-text'
        wrapper.contentEditable = true
        wrapper.spellcheck = true
        wrapper.dir = "auto"
        wrapper.lang = 'pt-BR'
        wrapper.dataset.placeholder = 'Start writing your article...'
        shadow.append(editorStyle)
        shadow.appendChild(wrapper)
    }
}

customElements.define('myb-textarea', MyBTextarea)

console.log(document.querySelector('myb-textarea').shadowRoot)


const MybEditor = function(options){
    const textarea = document.querySelector(options.textarea)
    textarea.hidden = true
    const dadE = textarea.parentNode;
    const mybEdit = document.createElement('myb-editor')
    mybEdit.dataset.textarea = options.textarea

    /*create toolbar*/
    const mybToolbar = document.createElement('myb-toolbar')
    var buttonActions = ["bold","italic"]
    for(btnAct of buttonActions){
        var button = document.createElement('button');
        button.innerHTML = btnAct
        button.dataset.action = btnAct
        button.addEventListener('click', e => {
            e.preventDefault()
            this.change(e)
            document.execCommand("selectAll", false, null);
        })
        mybToolbar.append(button)
    }
    const mybTextarea = document.createElement('iframe')
    mybTextarea.className = "myb-textarea"
    mybTextarea.onload = (e) => {
        const head = document.createElement('head')
        const style = document.createElement('link')
        const textbody = document.createElement('body')
        textbody.id = 'myb-text'
        textbody.contentEditable = true
        textbody.spellcheck = true
        textbody.lang = 'pt-BR'
        textbody.innerHTML += "Olá Mundo"
        mybText = e.target.contentWindow.document
        mybText.open('text/html')
        mybText.appendChild(textbody)
        mybText.close()

        console.log(e.target.contentWindow.document)
    }
    
    const mybFooter = document.createElement('myb-footer')

    mybEdit.append(mybToolbar)
    mybEdit.appendChild(mybTextarea)
    mybEdit.appendChild(mybFooter)

    mybTextarea.oninput = e => {
        let text = e.target.shadowRoot.querySelector('#myb-text').innerHTML
        textarea.value = text
        console.log(text)
    }

    dadE.insertBefore(mybEdit,textarea)
}

MybEditor.prototype.change = function(e){
    console.log(e)
}