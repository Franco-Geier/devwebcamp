(function() {
    const speakersInput = document.querySelector("#speakers");

    if(speakersInput) {
        let speakers = [];
        let filteredSpeakers = [];

        const speakersList = document.querySelector("#speakers-list");
        const hiddenSpeaker = document.querySelector('[name="speaker_id"]')

        getSpeakers();

        speakersInput.addEventListener("input", searchSpeakers);

        async function getSpeakers() {
            const url = `/api/speakers`;
            const response = await fetch(url);
            const result = await response.json();
            
            formatSpeakers(result);
        }

        function formatSpeakers(speakersArray = []) {
            speakers = speakersArray.map(speaker => {
                return {
                    nombre: `${speaker.name} ${speaker.last_name}`,
                    id: speaker.id
                }
            })
        }

        function searchSpeakers(e) {
            const search = e.target.value;
            
            if(search.length >= 3) {
                const expression = new RegExp(search, "i");
                filteredSpeakers = speakers.filter(speaker => {
                    if(speaker.nombre.toLowerCase().search(expression) != -1) {
                        return speaker;
                    }
                })
                showSpeakers();
            } else {
                filteredSpeakers = [];
                showSpeakers();
            }
        }

        function showSpeakers() {
            while(speakersList.firstChild) {
                speakersList.removeChild(speakersList.firstChild);
            }

            if(filteredSpeakers.length > 0) {
                filteredSpeakers.forEach(speaker => {
                    const speakerHTML = document.createElement("LI");
                    speakerHTML.classList.add("speakers-list__speaker");
                    speakerHTML.textContent = speaker.nombre;
                    speakerHTML.dataset.speakerId = speaker.id;
                    speakerHTML.onclick = chooseSpeaker;

                    // Añadir al DOM
                    speakersList.append(speakerHTML);
                })
            } else {
                const noResult = document.createElement("P");
                noResult.classList.add("speakers-list__no-result");
                noResult.textContent = "No hay resultados para tu búsqueda";
                speakersList.append(noResult);
            }
        }

        function chooseSpeaker(e) {
            const speaker = e.target;
            
            // remover clase previa
            const previousSpeaker = document.querySelector(".speakers-list__speaker--choosed");
            if(previousSpeaker) {
                previousSpeaker.classList.remove("speakers-list__speaker--choosed");
            }

            speaker.classList.add("speakers-list__speaker--choosed");
            hiddenSpeaker.value = speaker.dataset.speakerId;
        }
    }
})();