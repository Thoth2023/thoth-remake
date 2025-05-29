<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link
        rel="apple-touch-icon"
        sizes="76x76"
        href="{{ asset("img/apple-icon.png") }}"
    />
    <link
        rel="icon"
        type="image/png"
        href="{{ asset("img/favicon.png") }}"
    />
    <title>Thoth :: Tool for SLR</title>
    <!-- PWA  -->
    <meta name="theme-color" content="#c9c5b1" />
    <link rel="apple-touch-icon" href="{{ asset("logo.PNG") }}" />
    <link rel="manifest" href="{{ asset("/manifest.json") }}" />

    <!-- Fonts and icons -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700"
        rel="stylesheet"
    />
    <!-- Nucleo Icons -->
    <link
        href="{{ asset("assets/css/nucleo-icons.css") }}"
        rel="stylesheet"
    />
    <link
        href="{{ asset("assets/css/nucleo-svg.css") }}"
        rel="stylesheet"
    />

    <link
        href="{{ asset("assets/css/nucleo-svg.css") }}"
        rel="stylesheet"
    />

    <link
        href="{{ asset("assets/fontawesome-free-6.6.0-web/css/all.min.css") }}"
        rel="stylesheet"
    />

    <!-- CSS Files -->
    <link
        id="pagestyle"
        href="{{ asset("assets/css/argon-dashboard.css") }}"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="{{ asset("assets/css/select.css") }}" />
    <link rel="stylesheet" href="{{ asset("assets/css/styles.css") }}" />

    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">



    <!-- Google reCaptcha-->
    @if(request()->is('register'))
        <script
            src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    @endif


    <!--editor de richtexto Quill -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/choices.js@9.0.1/public/assets/scripts/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireStyles
</head>

<body
class="g-sidenav-show {{ in_array( request()->route()->getName(),["login", "reset-password", "change-password","message"],) ? "bg-white" : "bg-gray-300" }}">
    @guest
    @yield("content")
    @endguest

    @auth
    @if (in_array(request()->route()->getName(),["login", "register", "reset-password", "change-password","message"]))
    @yield("content")
    @else
    @if (! in_array(request()->route()->getName(),["profile", "home", "about", "help", "database-manager"]))
    <div
        class="bg-gradient-faded-dark opacity-8 position-absolute w-100"
        style="min-height: 280px"></div>
    @elseif (in_array(request()->route()->getName(),["profile-static", "profile"]))
    <div
        class="bg-gradient-faded-dark position-absolute w-100 min-height-300 top-0">
        >
        <span class="mask bg-primary opacity-8"></span>
    </div>
    @endif
    @include("layouts.navbars.auth.sidenav")
    <main class="main-content">
        <div class="container">
            @yield("content")

            {{-- para exibir o chat apenas nas paginas do projeto --}}
            @if (
                request()->routeIs('projects.show') ||
                str_starts_with(request()->route()->getName(), 'project.')
            )
                @isset($project)
                    @include('components.chat', ['projeto_id' => $project->id_project])
                @endisset
            @endif
        </div>
    </main>
    @include("components.fixed-plugin")
    @endif
    @endauth

    <!-- PWA service worker -->
    <script>
        if (typeof navigator.serviceWorker !== 'undefined') {
            navigator.serviceWorker.register('pwabuilder-sw.js');
        }
    </script>

    <!-- Core JS Files -->
    <script src="{{ asset("assets/js/core/popper.min.js") }}"></script>
    <script src="{{ asset("assets/js/core/bootstrap.min.js") }}"></script>
    <script src="{{ asset("assets/js/plugins/perfect-scrollbar.min.js") }}"></script>
    <script src="{{ asset("assets/js/plugins/smooth-scrollbar.min.js") }}"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5',
            };
            Scrollbar.init(
                document.querySelector('#sidenav-scrollbar'),
                options,
            );
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->

    <script src="{{ asset("assets/js/argon-dashboard.js") }}"></script>
    <script src="{{ asset("resources/js/app.js") }}" defer></script>
    @stack("js")

    <script src="{{ asset("/pwabuilder-sw.js") }}"></script>
    <script>
        if ('serviceWorker' in navigator) {
            // Register a service worker hosted at the root of the
            // site using the default scope.
            navigator.serviceWorker.register('/pwabuilder-sw.js').then(
                (registration) => {
                    console.log(
                        'Service worker registration succeeded:',
                        registration,
                    );
                },
                (error) => {
                    console.error(
                        `Service worker registration failed: ${error}`,
                    );
                },
            );
        } else {
            console.error('Service workers are not supported.');
        }
    </script>
	
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastContainer = document.querySelector('.toast-container');
            const toastElement = toastContainer.querySelector('.toast');
            const toastBody = toastElement.querySelector('.toast-body');
            const toastTime = toastElement.querySelector('.toast-time');

            function showToast(message, type) {
                toastBody.innerText = message;
                toastElement.querySelector('.toast-header strong').innerText = type;
                const toast = new bootstrap.Toast(toastElement);
                toast.show();
            }

            // Check if there's an error or success flash message
            const errorMessage = "{{ session('error') }}";
            const successMessage = "{{ session('success') }}";

            if (errorMessage) {
                showToast(errorMessage, 'Error');
            } else if (successMessage) {
                showToast(successMessage, 'Success');
            } else {
                // Check for validation errors
                @if($errors -> any())
                const validationErrors = @json($errors -> all());
                showToast(validationErrors.join(' '), 'Error');
                @endif
            }

        });
    </script>



    {{-- Search input js logic --}}
    <script src="{{ asset("assets/js/utils.js") }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_API_KEY") }}&libraries=places"></script>
    <script src="{{ asset("assets/js/cep_autocomplete.js") }}"></script>
    @stack("scripts")
    @livewireScripts


        @auth
    <script>
        const usuarioLogado = @json(Auth::user()->name);
    </script>
    @endauth



    @auth
    <!-- CHAT flutuante -->
    <div id="chat-container" style="position:fixed; bottom:0; right:15px; width:300px; z-index:9999;">
        <div id="chat-header" style="background:#007bff;color:#fff;padding:8px;cursor:pointer;">
            Chat do Projeto
            <span id="chat-notif" style="float:right;background:red;padding:2px 5px;border-radius:10px;display:none;">!</span>
        </div>
        <div id="chat-body" style="border:1px solid #ccc;background:#fff;height:250px;overflow:auto;display:none;padding:10px;">
            <div id="chat-messages" style="height:150px; overflow-y: auto;"></div>
            <textarea id="chat-input" placeholder="Digite sua mensagem..." style="width:100%;height:50px;"></textarea>
            <button id="chat-send" style="width:100%;margin-top:5px;">Enviar</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let chatOpen = false;

            const chatHeader = document.getElementById('chat-header');
            const chatBody = document.getElementById('chat-body');
            const chatNotif = document.getElementById('chat-notif');
            const chatSend = document.getElementById('chat-send');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');

            const projetoId = {{ $projeto_id ?? 1 }};
            const usuarioLogado = {@json(Auth::user()->name)};


            chatHeader.addEventListener('click', function() {
                chatOpen = !chatOpen;
                chatBody.style.display = chatOpen ? 'block' : 'none';
                if (chatOpen) {
                    chatNotif.style.display = 'none';
                    carregarMensagens();
                }
            });

            function carregarMensagens() {
                fetch(`/chat/${projetoId}/messages`)
                    .then(resp => resp.json())
                    .then(data => {
                        chatMessages.innerHTML = '';
                        data.forEach(msg => {
                            chatMessages.innerHTML += `<div><strong>${msg.usuario}</strong>: ${msg.mensagem}</div>`;
                        });
                        chatMessages.scrollTop = chatMessages.scrollHeight;
                    })
                    .catch(err => console.error("Erro ao carregar mensagens:", err));
            }

            chatSend.addEventListener('click', function() {
                const mensagem = chatInput.value.trim();
                if (!mensagem) return;

                fetch(`/chat/${projetoId}/messages`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            usuario: usuarioLogado,
                            mensagem: mensagem
                        })
                    })
                    .then(() => {
                        chatInput.value = '';
                        carregarMensagens();
                    })
                    .catch(err => console.error("Erro ao enviar mensagem:", err));
            });

            // Carregar mensagens inicialmente
            carregarMensagens();

            // Atualização periódica e notificação
            setInterval(() => {
                if (!chatOpen) {
                    fetch(`/chat/${projetoId}/messages`)
                        .then(resp => resp.json())
                        .then(data => {
                            if (data.length > 0) {
                                chatNotif.style.display = 'inline';
                            }
                        });
                } else {
                    carregarMensagens();
                }
            }, 5000);
        });
    </script>
    @endauth


</body>

        {{-- Search input js logic --}}
        <script src="{{ asset("assets/js/utils.js") }}"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key={{ env("GOOGLE_API_KEY") }}&libraries=places"></script>
        <script src="{{ asset("assets/js/cep_autocomplete.js") }}"></script>
        @stack("scripts")
        @livewireScripts

        <script>
        // Function to handle input suggestion storage
        function setupInputSuggestions() {
            // Get all inputs with datalists
            const inputsWithDatalist = document.querySelectorAll('input[list]');
            
            // Debounce function to limit how often we save
            function debounce(func, wait) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                };
            }
            
            inputsWithDatalist.forEach(input => {
                const datalistId = input.getAttribute('list');
                const datalist = document.getElementById(datalistId);
                const storageKey = `suggestions_${input.id || input.name}`;
                
                // Load existing suggestions from localStorage
                const savedSuggestions = localStorage.getItem(storageKey);
                if (savedSuggestions) {
                    const suggestions = JSON.parse(savedSuggestions);
                    suggestions.forEach(suggestion => {
                        // Add to datalist if it doesn't already exist
                        if (!Array.from(datalist.options).some(option => option.value === suggestion)) {
                            const option = document.createElement('option');
                            option.value = suggestion;
                            datalist.appendChild(option);
                        }
                    });
                }
                
                // Function to save suggestion
                const saveSuggestion = () => {
                    const value = input.value.trim();
                    if (value) {
                        let suggestions = [];
                        if (localStorage.getItem(storageKey)) {
                            suggestions = JSON.parse(localStorage.getItem(storageKey));
                        }
                        
                        // Add new suggestion if it doesn't exist
                        if (!suggestions.includes(value)) {
                            suggestions.push(value);
                            localStorage.setItem(storageKey, JSON.stringify(suggestions));
                            
                            // Add to datalist if needed
                            if (!Array.from(datalist.options).some(option => option.value === value)) {
                                const option = document.createElement('option');
                                option.value = value;
                                datalist.appendChild(option);
                            }
                        }
                    }
                };
                
                // Debounced version for input event
                const debouncedSave = debounce(saveSuggestion, 300);
                
                // Listen for input (typing) events - save while typing
                input.addEventListener('input', debouncedSave);
                
                // Also listen for change events (when input loses focus)
                input.addEventListener('change', saveSuggestion);
                
                // Special handling for Livewire: save before Livewire updates
                input.addEventListener('keydown', function(e) {
                    // Save immediately on Tab or Enter
                    if (e.key === 'Tab' || e.key === 'Enter') {
                        saveSuggestion();
                    }
                });
                
                // Save on blur (when focus leaves the input)
                input.addEventListener('blur', saveSuggestion);
                
                // Handle Livewire update - very important
                input.addEventListener('beforeinput', saveSuggestion);
                
                // Create a hidden form to prevent browser autocomplete from being blocked
                const form = document.createElement('form');
                form.style.display = 'none';
                form.setAttribute('autocomplete', 'on');
                document.body.appendChild(form);
                
                // Clone the input and append to hidden form
                const clonedInput = input.cloneNode(true);
                clonedInput.removeAttribute('wire:model');
                form.appendChild(clonedInput);
                
                // Sync values between visible and hidden inputs
                input.addEventListener('input', function() {
                    clonedInput.value = input.value;
                });
            });
        }

        // Special handler for Livewire operations
        document.addEventListener('livewire:update', function() {
            // Save all input values before Livewire updates
            document.querySelectorAll('input[list]').forEach(input => {
                const storageKey = `suggestions_${input.id || input.name}`;
                const value = input.value.trim();
                
                if (value) {
                    let suggestions = [];
                    if (localStorage.getItem(storageKey)) {
                        suggestions = JSON.parse(localStorage.getItem(storageKey));
                    }
                    
                    if (!suggestions.includes(value)) {
                        suggestions.push(value);
                        localStorage.setItem(storageKey, JSON.stringify(suggestions));
                    }
                }
            });
        });

        // Run when DOM is loaded
        document.addEventListener('DOMContentLoaded', setupInputSuggestions);

        // For Livewire components that may load after page load
        document.addEventListener('livewire:initialized', setupInputSuggestions);
        document.addEventListener('livewire:navigated', setupInputSuggestions);
        </script>

        <script>
        // Make values available immediately
        function populateSuggestions() {
            // Add common values for each input type
            const commonFields = {
                'de_question_id': ['QA01', 'Q1', 'DE1', 'QD1', 'D1'],
                'criteria_id': ['IC1', 'IC2', 'EC1', 'EC2'],
                'quality_question_id': ['QA01', 'QA02', 'QA1', 'QA2'],
                'research_question_id': ['RQ1', 'RQ2', 'RQ3', 'GQ1']
            };
            
            // Add these to localStorage for immediate availability
            for (const [fieldName, values] of Object.entries(commonFields)) {
                const storageKey = `suggestions_${fieldName}`;
                let suggestions = [];
                
                // Get existing suggestions
                if (localStorage.getItem(storageKey)) {
                    suggestions = JSON.parse(localStorage.getItem(storageKey));
                }
                
                // Add new common values if they don't exist
                values.forEach(value => {
                    if (!suggestions.includes(value)) {
                        suggestions.push(value);
                    }
                });
                
                // Save back to localStorage
                localStorage.setItem(storageKey, JSON.stringify(suggestions));
            }
        }

        // Run immediately
        populateSuggestions();
        </script>

        <script>
        // Force browser to refresh autocomplete suggestions
        function forceBrowserAutocompleteRefresh() {
            // Create a temporary hidden iframe to force browser cache refresh
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);
            
            // Create a form inside the iframe with autocomplete on
            const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            iframeDoc.body.innerHTML = '<form autocomplete="on" id="temp-form"></form>';
            const tempForm = iframeDoc.getElementById('temp-form');
            
            // For each input we care about, create a parallel input in the iframe
            const inputFields = document.querySelectorAll('input[list]');
            inputFields.forEach(input => {
                const name = input.name || input.id;
                const value = input.value;
                
                if (value) {
                    // Get existing suggestions
                    const storageKey = `suggestions_${name}`;
                    let suggestions = [];
                    if (localStorage.getItem(storageKey)) {
                        suggestions = JSON.parse(localStorage.getItem(storageKey));
                    }
                    
                    // Add the new value if not present
                    if (!suggestions.includes(value)) {
                        suggestions.push(value);
                        localStorage.setItem(storageKey, JSON.stringify(suggestions));
                    }
                    
                    // Create all inputs and add all values as options in the iframe
                    suggestions.forEach((suggestion, index) => {
                        const tempInput = document.createElement('input');
                        tempInput.type = 'text';
                        tempInput.name = `${name}_${index}`;
                        tempInput.value = suggestion;
                        tempInput.setAttribute('autocomplete', 'on');
                        tempForm.appendChild(tempInput);
                    });
                }
            });
            
            // Submit the form to register values with browser's autocomplete
            tempForm.submit();
            
            // Clean up after a delay
            setTimeout(() => {
                document.body.removeChild(iframe);
            }, 500);
        }

        // Run this function whenever a form is submitted
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (form.querySelector('input[list]')) {
                forceBrowserAutocompleteRefresh();
            }
        });

        // Also run for direct input changes
        document.addEventListener('change', function(e) {
            if (e.target.hasAttribute('list')) {
                // Small delay to let the input value settle
                setTimeout(() => forceBrowserAutocompleteRefresh(), 50);
            }
        });
        </script>

        <script>
        // Bypass browser autocomplete memory limitations
        (function() {
            // Store a reference to all suggestions
            const allSuggestions = {}; 
            
            // Special workaround to force browser to update input suggestions
            function refreshInputBrowserCache(input) {
                // Create a form that we'll later submit and destroy
                const formId = `form-refresh-${Math.random().toString(36).substring(2)}`;
                const form = document.createElement('form');
                form.id = formId;
                form.method = 'post';
                form.action = 'javascript:void(0)';
                form.style.position = 'absolute';
                form.style.left = '-9999px';
                form.setAttribute('autocomplete', 'on');
                document.body.appendChild(form);
                
                // Create a reset button to clear browser cache
                const resetBtn = document.createElement('button');
                resetBtn.type = 'reset';
                form.appendChild(resetBtn);
                
                // Reset the form to clear browser state
                resetBtn.click();
                
                // Create a clone of our input
                const inputClone = document.createElement('input');
                inputClone.type = 'text';
                inputClone.name = input.name || input.id;
                inputClone.setAttribute('autocomplete', 'on');
                form.appendChild(inputClone);
                
                // Get all suggestions for this input
                const storageKey = `suggestions_${input.name || input.id}`;
                if (localStorage.getItem(storageKey)) {
                    const suggestions = JSON.parse(localStorage.getItem(storageKey));
                    
                    // We'll use this to preserve our suggestions
                    allSuggestions[storageKey] = suggestions;
                    
                    // Create a hidden submit button
                    const submitBtn = document.createElement('button');
                    submitBtn.type = 'submit';
                    submitBtn.style.display = 'none';
                    form.appendChild(submitBtn);
                    
                    // For each suggestion, set the value and submit the form
                    // This forces the browser to register each value
                    for (let i = 0; i < suggestions.length; i++) {
                        const suggestion = suggestions[i];
                        
                        // Set value and trigger events
                        inputClone.value = suggestion;
                        inputClone.dispatchEvent(new Event('input', { bubbles: true }));
                        inputClone.dispatchEvent(new Event('change', { bubbles: true }));
                        
                        // Submit the form for this value
                        submitBtn.click();
                    }
                }
                
                // Remove the temporary form
                setTimeout(() => document.body.removeChild(form), 100);
            }
            
            // Monitor for new inputs and refresh their cache
            function checkForNewInputs() {
                document.querySelectorAll('input[list]').forEach(input => {
                    const name = input.name || input.id;
                    if (name && !input.hasAttribute('data-autocomplete-monitored')) {
                        input.setAttribute('data-autocomplete-monitored', 'true');
                        
                        // Immediately refresh this input's cache
                        refreshInputBrowserCache(input);
                        
                        // Set up event listeners
                        input.addEventListener('focus', () => refreshInputBrowserCache(input));
                        
                        // Save new values when they're entered
                        input.addEventListener('change', function() {
                            const value = this.value.trim();
                            if (value) {
                                const storageKey = `suggestions_${name}`;
                                let suggestions = allSuggestions[storageKey] || [];
                                
                                if (!suggestions.includes(value)) {
                                    suggestions.push(value);
                                    allSuggestions[storageKey] = suggestions;
                                    localStorage.setItem(storageKey, JSON.stringify(suggestions));
                                    
                                    // Update datalist
                                    const datalistId = input.getAttribute('list');
                                    if (datalistId) {
                                        const datalist = document.getElementById(datalistId);
                                        if (datalist) {
                                            // Add the new option
                                            const option = document.createElement('option');
                                            option.value = value;
                                            datalist.appendChild(option);
                                        }
                                    }
                                    
                                    // Force browser to update
                                    refreshInputBrowserCache(input);
                                }
                            }
                        });
                    }
                });
            }
            
            // Check regularly for new inputs
            setInterval(checkForNewInputs, 1000);
            
            // Initial check on page load
            document.addEventListener('DOMContentLoaded', checkForNewInputs);
            
            // Check after Livewire updates
            document.addEventListener('livewire:load', checkForNewInputs);
            document.addEventListener('livewire:update', checkForNewInputs);
        })();
        </script>

        <script>
        // Function for the refresh button
        function refreshSuggestions(inputId, inputName, datalistId, showAlert = true) {
            // Find the input and datalist elements
            const input = document.getElementById(inputId);
            const datalist = document.getElementById(datalistId);
            
            if (!input || !datalist) return;
            
            // Clear the browser's cache by toggling autocomplete
            input.setAttribute('autocomplete', 'off');
            
            // Get current values from localStorage
            const storageKey = `suggestions_${inputName || inputId}`;
            let suggestions = [];
            
            if (localStorage.getItem(storageKey)) {
                suggestions = JSON.parse(localStorage.getItem(storageKey));
            }
            
            // Add the current value if it's not already in the list
            const currentValue = input.value.trim();
            if (currentValue && !suggestions.includes(currentValue)) {
                suggestions.push(currentValue);
                localStorage.setItem(storageKey, JSON.stringify(suggestions));
            }
            
            // Clear and rebuild the datalist
            datalist.innerHTML = '';
            suggestions.forEach(suggestion => {
                const option = document.createElement('option');
                option.value = suggestion;
                datalist.appendChild(option);
            });
            
            // Create a hidden form to force browser to register suggestions
            const form = document.createElement('form');
            form.setAttribute('autocomplete', 'on');
            form.style.position = 'absolute';
            form.style.left = '-9999px';
            document.body.appendChild(form);
            
            // Add a hidden input for each suggestion
            suggestions.forEach((suggestion, index) => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'text';
                hiddenInput.name = `${inputName || inputId}_${index}`;
                hiddenInput.value = suggestion;
                hiddenInput.setAttribute('autocomplete', 'on');
                form.appendChild(hiddenInput);
            });
            
            // Submit the form to register with browser
            form.submit();
            
            // Remove the form after a delay
            setTimeout(() => {
                document.body.removeChild(form);
                
                // Re-enable autocomplete on the original input
                input.setAttribute('autocomplete', 'on');
                
                // Show a message only if requested
                if (showAlert) {
                    alert("Sugestões atualizadas! Agora você pode começar a digitar para ver todas as sugestões.");
                }
            }, 500);
        }
        </script>

        <script>
        // Automatically refresh suggestions on form submit
        document.addEventListener('DOMContentLoaded', function() {
            // Find all forms with Livewire submit handlers
            document.querySelectorAll('form[wire\\:submit]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Find all input fields with datalists in this form
                    const inputs = form.querySelectorAll('input[list]');
                    
                    // For each input, refresh its suggestions
                    inputs.forEach(input => {
                        const inputId = input.id;
                        const inputName = input.name || input.id;
                        const datalistId = input.getAttribute('list');
                        
                        // Use a small setTimeout to ensure this runs after the Livewire update
                        setTimeout(() => {
                            refreshSuggestions(inputId, inputName, datalistId, false);
                        }, 500);
                    });
                });
            });
            
            // Also monitor Livewire events for form submission
            document.addEventListener('livewire:load', function() {
                if (typeof window.Livewire !== 'undefined') {
                    // After Livewire finishes updating, refresh suggestions
                    window.Livewire.hook('message.processed', (message, component) => {
                        if (message.updateQueue && message.updateQueue.length) {
                            // Find all inputs with datalists
                            document.querySelectorAll('input[list]').forEach(input => {
                                const inputId = input.id;
                                const inputName = input.name || input.id;
                                const datalistId = input.getAttribute('list');
                                
                                // Refresh silently without alert
                                refreshSuggestions(inputId, inputName, datalistId, false);
                            });
                        }
                    });
                }
            });
        });
        </script>

        <script>
        // Watch for Livewire form submissions and update suggestions
        document.addEventListener('livewire:load', function() {
            if (typeof window.Livewire !== 'undefined') {
                // Before Livewire sends a request, save current input values
                window.Livewire.hook('message.sent', (message, component) => {
                    // Get all inputs with datalists
                    const inputs = document.querySelectorAll('input[list]');
                    inputs.forEach(input => {
                        const value = input.value.trim();
                        if (value) {
                            const storageKey = `suggestions_${input.name || input.id}`;
                            let suggestions = [];
                            
                            if (localStorage.getItem(storageKey)) {
                                suggestions = JSON.parse(localStorage.getItem(storageKey));
                            }
                            
                            if (!suggestions.includes(value)) {
                                suggestions.push(value);
                                localStorage.setItem(storageKey, JSON.stringify(suggestions));
                            }
                        }
                    });
                });
                
                // After Livewire processes a request, update suggestions
                window.Livewire.hook('message.processed', (message, component) => {
                    // Wait a bit for the DOM to settle
                    setTimeout(() => {
                        // Update all datalists with saved suggestions
                        document.querySelectorAll('input[list]').forEach(input => {
                            const datalistId = input.getAttribute('list');
                            const datalist = document.getElementById(datalistId);
                            
                            if (datalist) {
                                const storageKey = `suggestions_${input.name || input.id}`;
                                if (localStorage.getItem(storageKey)) {
                                    // Get saved suggestions
                                    const suggestions = JSON.parse(localStorage.getItem(storageKey));
                                    
                                    // Clear datalist
                                    datalist.innerHTML = '';
                                    
                                    // Add all suggestions as options
                                    suggestions.forEach(suggestion => {
                                        const option = document.createElement('option');
                                        option.value = suggestion;
                                        datalist.appendChild(option);
                                    });
                                }
                            }
                        });
                        
                        // Also force browser to refresh its autocomplete cache
                        document.querySelectorAll('input[list]').forEach(input => {
                            const inputId = input.id;
                            const inputName = input.name;
                            const datalistId = input.getAttribute('list');
                            
                            if (inputId && inputName && datalistId) {
                                refreshSuggestions(inputId, inputName, datalistId, false);
                            }
                        });
                    }, 300);
                });
            }
        });
        </script>
    </body>
</html>
