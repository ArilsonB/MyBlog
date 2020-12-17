
        const checkLogin = (user) => fetch(`logapi.php?user=${user}`).then(res => res.json())

        const event = (fn, wait = 500, time) => (...args) => {
            clearTimeout(time)
            time = setTimeout(() => fn(...args), wait)
        }

        const handle = (e) => {
            var label = document.querySelector('label > h2')
            var submit = document.querySelector('.submit')
            var pass = document.querySelector('.pass')

            checkLogin(e.target.value)
            .then(users => users.map(user => {
                label.innerHTML = user.fullname
                submit.removeAttribute('disabled')
                e.target.parentNode.style.display = 'none'
                pass.style.display = 'block'
            }))

            return false;
        }

        let umail = document.querySelector('#umail');
        umail.addEventListener('keyup', event(handle, 500))

        const submitForm = (e) => {
            e.preventDefault()
            let data = new FormData(e.target)

            const login = (data) => fetch('/req_login',{
                method: 'POST',
                body: data
            })
            .then((res) => res.json())
            .catch((error) => console.error(error.message))

            login(data)
            .then((login) => {
                if(login.redirect !== undefined){
                    e.target.style.display = 'none'
                    var lab = document.querySelector('p.myb__infos')
                    lab.className += ' success'
                    lab.innerHTML = 'logging...'
                    lab.style.display = 'block'
                    setTimeout(() => window.location.href = login.redirect, 500)
                }else{
                    var labe = document.querySelector('p.myb__infos')
                    labe.className += ' error'
                    labe.innerHTML = login.message
                    labe.style.display = 'block'
                }
            })
        }

        let box = document.querySelector('.myb__login-box');
        let form = document.querySelector(".myb__login-form");
        form.addEventListener('submit', submitForm)
