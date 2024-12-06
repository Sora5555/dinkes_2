        {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
        <script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script>
        <script>
            let asset_url = '{{asset('assets/css/app.min.css')}}';
            let bootstrap_url = '{{asset('assets/css/bootstrap.min.css')}}';
        </script>

        <script src="{{asset('assets/js/app.js')}}"></script>

        <script>
            $(document).ready(function(){
                const simpleBar = new SimpleBar(document.getElementById('notification-list'));
                $(document).on('submit','.delete-data',function(e){
                    if(!confirm('Yakin ingin menghapus data ini?!'))
                        e.preventDefault();
                });

                let notifOpen = 0;
                let notifButton = document.querySelector('#page-header-notifications-dropdown');
                let notificationList = document.querySelector('.simplebar-content');

                notifButton.addEventListener('click', function (e){

                    if(notifButton.classList.contains('show')){
                        // simpleBar.unMount()
                        console.log('Opened');
                        $('#notification-list .simplebar-content').empty();

                    }else if(!notifButton.classList.contains('show')){
                        console.log('Closed');
                    }
                    
                    
                });
            });
            $("#tahun").change(function() {
                console.log($(this).val);
                let tahun = $(this).val();
                $.ajax({
                    type: "get",
                    url: `{{url('home/filterTahun')}}/${tahun}`,
                    success: (res) => {
                        if(res.status == 'success'){
                        alert("Filter sukses");
                        location.reload();
                        } else {
                            alert("Filter gagal");
                        }
                    }
                })
            })
            const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;
            // window.addEventListener('load', function () {
            //     postData('{{ route("pelanggan.data") }}','POST', { _token: csrfToken ,id: 1 })
            // .then(data => {
            //     console.log(data); // JSON data parsed by `data.json()` call
            // });
            // })

            async function postData(url = '', url_method = 'POST',  data = {}) {
                let response;
                if(url_method == 'POST'){
                    response = await fetch(url, {
                    method: url_method,
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                    "X-CSRFToken" :csrfToken,
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",

                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer',
                    body: JSON.stringify(data)
                });
                }else if(url_method == 'GET'){
                    response = await fetch(url, {
                    method: url_method,
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                    "X-CSRFToken" :csrfToken,
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest",

                    },
                    redirect: 'follow',
                    referrerPolicy: 'no-referrer'
                });
                }
                
                return response.json();
            }

            

        const image_button = document.getElementsByClassName('image_button');

        // image_button.addEventListener('click', (event) => {
        //     console.log(this.getAttribute('data-url'));
        // });

        var myFunction = function() {
            var attribute = this.getAttribute("data-url");
            console.log(attribute);
        };  

        Array.from(image_button).forEach(function(element) {
            element.addEventListener('click', myFunction);
        });

        let image_show = function(url){
            console.log(url);
            src = url;
            img = document.createElement('img');

            img.src = src;

            img.style.height = '100%';
            img.style.width = '100%';

            let modal_gambar = document.querySelector('#modal_gambar');

            modal_gambar.innerHTML ='';

            modal_gambar.appendChild(img);
        }

        // Restricts input for the given textbox to the given inputFilter.
        function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
            });
        });
        }
        </script>

        @stack('scripts')

    </body>
</html>