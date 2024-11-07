{{-- this is from the window's queueing --}}
<script>
    let fetchInterval;

    function fetchUsers() {
        $.get('/client', function(client) {
            console.log(client);

            // Ensure the response is an array
            if (Array.isArray(client)) {
                // Limit the list to 10 items (if more than 10)
                const limitedClientList = client.slice(0, 10);

                let userListHtml = '';

                // Generate list items with numbers, up to 10
                for (let i = 0; i < 10; i++) {
                    const listItemClass = i === 0 ?
                        'fw-bold text-start queue-waiting p-3 bg-opacity-75 list-group-item text-start' :
                        'text-start list-group-item pl-6  pt-3 pb-3 text-start';

                    // If we have data for this index, show it
                    if (i < limitedClientList.length) {
                        userListHtml +=
                            `<li class="${listItemClass}">${i + 1}. ${limitedClientList[i].name} - ${limitedClientList[i].number}</li>`;
                    } else {
                        // If no data for this index, show an empty row with the number
                        userListHtml +=
                            `<li class="${listItemClass}">${i + 1}. </li>`;
                    }
                }

                // Update the user list
                $('#user-list').html(userListHtml);

                // Stop refreshing if we have 10 items
                if (limitedClientList.length >= 10) {
                    clearInterval(fetchInterval);
                }
            } else {
                console.error('Expected an array of users, but got:', client);
            }
        }).fail(function() {
            console.error('Error fetching users');
        });
    }

    // Start fetching users every 3 seconds
    function startAutoRefresh() {
        fetchInterval = setInterval(fetchUsers, 3000);
    }

    startAutoRefresh();
</script>

<script>
    document.getElementById('fetch-oldest-client').addEventListener('click', function() {
        fetch('/get-oldest-client')
            .then(response => response.json())
            .then(data => {
                // If data exists, update the HTML, otherwise set to '---'
                const clientName = data.name || '---';
                const clientNumber = data.number || '---';

                // Update client info on the page
                document.getElementById('client-name').innerText = clientName;
                document.getElementById('client-number').innerText = clientNumber;

                // Change 'Now Serving' to 'Waiting' if client number is '---'
                const nowServingElement = document.getElementById('now-serving');
                if (clientNumber === '---') {
                    nowServingElement.innerText = 'Waiting';
                } else {
                    nowServingElement.innerText = 'Now Serving';
                }




                let fetchInterval;

                function fetchUsers() {
                    $.get('/client', function(client) {
                        console.log(client);

                        // Ensure the response is an array
                        if (Array.isArray(client)) {
                            // Limit the list to 10 items (if more than 10)
                            const limitedClientList = client.slice(0, 10);

                            let userListHtml = '';

                            // Generate list items with numbers, up to 10
                            for (let i = 0; i < 10; i++) {
                                const listItemClass = i === 0 ?
                                    'fw-bold text-start queue-waiting p-3 bg-opacity-75 list-group-item text-start' :
                                    'text-start list-group-item pl-6  pt-3 pb-3 text-start';

                                // If we have data for this index, show it
                                if (i < limitedClientList.length) {
                                    userListHtml +=
                                        `<li class="${listItemClass}">${i + 1}. ${limitedClientList[i].name} - ${limitedClientList[i].number}</li>`;
                                } else {
                                    // If no data for this index, show an empty row with the number
                                    userListHtml +=
                                        `<li class="${listItemClass}">${i + 1}. </li>`;
                                }
                            }

                            // Update the user list
                            $('#user-list').html(userListHtml);

                            // Stop refreshing if we have 10 items
                            if (limitedClientList.length >= 10) {
                                clearInterval(fetchInterval);
                            }
                        } else {
                            console.error('Expected an array of users, but got:', client);
                        }
                    }).fail(function() {
                        console.error('Error fetching users');
                    });
                }

                // Start fetching users every 3 seconds
                function startAutoRefresh() {
                    fetchInterval = setInterval(fetchUsers, 3000);
                }

                startAutoRefresh();


















            })
            .catch(error => {
                console.error('Error fetching client data:', error);
                // In case of error, set both to '---' and set 'Now Serving' to 'Waiting'
                document.getElementById('client-name').innerText = '---';
                document.getElementById('client-number').innerText = '---';
                document.getElementById('now-serving').innerText = 'Waiting';
            });
    });
</script>


{{-- this is for wait button function --}}
<script>
    // Event listener for the "Wait" button
    document.getElementById('wait-button').addEventListener('click', function() {
        // Update the UI elements when "Wait" is clicked
        document.getElementById('now-serving').innerText = 'Waiting...';
        document.getElementById('client-number').innerText = '---';
        document.getElementById('client-name').innerText = '---';
    });
</script>

{{-- for notify button --}}

<script>
    // Event listener for the "Notify" button
    document.getElementById('notify-button').addEventListener('click', function() {
        // Get the current client number from the <span id="client-number">
        const clientNumber = document.getElementById('client-number').innerText;

        // If the client number is '---', don't notify
        if (clientNumber === '---') {
            alert("No client to notify.");
            return;
        }

        // Text that will be read aloud, including the client number
        const message = `The next client number is ${clientNumber}`;

        // Create a new SpeechSynthesisUtterance object
        const speech = new SpeechSynthesisUtterance(message);

        // You can customize the voice, rate, and pitch if needed
        speech.voice = speechSynthesis.getVoices()[0]; // Default voice
        speech.rate = 1; // Speed of the speech
        speech.pitch = 1; // Pitch of the speech

        // Speak the message
        speechSynthesis.speak(speech);
    });
</script>
