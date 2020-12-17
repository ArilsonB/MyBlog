
const myb_editor = document.querySelector('myb-editor')
const myb_textarea = document.querySelector('myb-editor > .myb-textarea > myb-textarea');
const myb_buttons = document.querySelectorAll('myb-editor > myb-toolbar > button');

document.execCommand('defaultParagraphSeparator', false, 'p');



const mybbutton = e => {
    e.preventDefault()
    const button = e.target;
    const action = button.dataset.action;
    const value = button.dataset.value;
    if(value){
        document.execCommand(action, false, "<"+value+">")
    }else{
        document.execCommand(action,false,null)
    }
} 


for(myb_button of myb_buttons){
    myb_button.addEventListener('click', mybbutton)
}



const mybText = (e) => {
    e.preventDefault()
    let content = e.target.shadowRoot.querySelector('#myb-text').innerHTML;
    let textarea = document.querySelector('myb-editor > .myb-textarea > textarea')
    textarea.value = content
    console.log(textarea.value)
}

myb_textarea.addEventListener('keyup',mybText);


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
        wrapper.innerHTML = `<p>&nbsp;</p>`
        shadow.append(editorStyle)
        shadow.appendChild(wrapper)
    }
}

customElements.define('myb-textarea', MyBTextarea)