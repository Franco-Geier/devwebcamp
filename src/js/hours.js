(function(){
    const hours = document.querySelector("#hours");

    if(hours) {
        let search = {
            category_id: '',
            day: ''
        };

        const category = document.querySelector('[name="category_id"]');
        const days = document.querySelectorAll('[name="day"]');
        const inputHiddenDay = document.querySelector('[name="day_id"]');
        const inputHiddenHour = document.querySelector('[name="hour_id"]');
        
        category.addEventListener("change", endSearch);
        days.forEach(day => day.addEventListener("change", endSearch));

        function endSearch(e) {
            search[e.target.name] = e.target.value;

            // Reiniciar los campos ocultos y el selector de horas
            inputHiddenHour.value = "";
            inputHiddenDay.value = "";
            const previousHour = document.querySelector(".hours__hour--selected");
            if(previousHour) {
                previousHour.classList.remove("hours__hour--selected");
            }

            // Si algún campo está vacío, deshabilitar todas las horas y salir
            if(Object.values(search).includes('')) {
                resetAllHours();
                return;
            }
            searchEvents();
        }

        async function searchEvents() {
            const {day, category_id} = search;
            const url = `/api/events-schedule?day_id=${day}&category_id=${category_id}`;
            const result = await fetch(url);
            const events = await result.json();

            getAvailableHours(events);
        }

        function getAvailableHours(events) {
            // Reiniciar las horas
            const hoursList = document.querySelectorAll("#hours li");
            hoursList.forEach(li => li.classList.add("hours__hour--disabled"));

            // Comprobar eventos ya tomados, y quitar la clase de disabled
            const hoursTaken = events.map(event => String(event.hour_id));
            const hoursListArray = Array.from(hoursList);

            const result = hoursListArray.filter(li => !hoursTaken.includes(li.dataset.hourId));
            result.forEach(li => li.classList.remove("hours__hour--disabled"));

            const availableHours = document.querySelectorAll("#hours li:not(.hours__hour--disabled)");
            availableHours.forEach(hour => hour.addEventListener("click", chooseHour));
        }

        function chooseHour(e) {
            // No hacer nada si la hora está deshabilitada
            if(e.target.classList.contains("hours__hour--disabled")) {
                return; // Salir temprano si la hora no está disponible
            }
            const previousHour = document.querySelector(".hours__hour--selected");

            if(previousHour) {
                previousHour.classList.remove("hours__hour--selected");
            }
            e.target.classList.add("hours__hour--selected");
            inputHiddenHour.value = e.target.dataset.hourId;

            // Llenar el campo oculto de día
            inputHiddenDay.value = document.querySelector('[name="day"]:checked').value;
        }

        function resetAllHours() {
            const hoursList = document.querySelectorAll("#hours li");
            hoursList.forEach(li => {
                li.classList.add("hours__hour--disabled");
                li.classList.remove("hours__hour--selected");
            });
        }
    }
})();