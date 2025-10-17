(function(){
    const hours = document.querySelector("#hours");

    if(hours) {

        const category = document.querySelector('[name="category_id"]');
        const days = document.querySelectorAll('[name="day"]');
        const inputHiddenDay = document.querySelector('[name="day_id"]');
        const inputHiddenHour = document.querySelector('[name="hour_id"]');
        const eventIdInput = document.querySelector('#event_id');

        // Guardar la configuración original completa del evento
        const originalConfig = {
            category_id: category.value,
            day_id: inputHiddenDay.value,
            hour_id: inputHiddenHour.value
        };
        
        category.addEventListener("change", endSearch);
        days.forEach(day => day.addEventListener("change", endSearch));

        let search = {
            category_id: +category.value || '',
            day: +inputHiddenDay.value || ''
        };

        // Si hay valores iniciales, cargar las horas
        if(!Object.values(search).includes('')) {
            (async () => {
                await searchEvents();
                
                // Solo al cargar la página por primera vez, marcar la hora original
                if(originalConfig.hour_id) {
                    const selectedHour = document.querySelector(`[data-hour-id="${originalConfig.hour_id}"]`);
                    if(selectedHour) {
                        selectedHour.classList.remove("hours__hour--disabled");
                        selectedHour.classList.add("hours__hour--selected");
                        selectedHour.onclick = chooseHour;
                    }
                }
            })();
        }

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

            // Si estamos editando, filtrar el evento actual de la lista
            let filteredEvents = events;
            if(eventIdInput && eventIdInput.value) {
                filteredEvents = events.filter(event => String(event.id) !== String(eventIdInput.value));
            }

            // Marcar horas ocupadas
            const hoursTaken = filteredEvents.map(event => String(event.hour_id));
            const hoursListArray = Array.from(hoursList);

            // Habilitar horas disponibles
            const availableHoursElements = hoursListArray.filter(li => !hoursTaken.includes(li.dataset.hourId));
            availableHoursElements.forEach(li => li.classList.remove("hours__hour--disabled"));

            // Verificar si estamos en la configuración original exacta
            const currentCategoryId = category.value;
            const currentDayId = document.querySelector('[name="day"]:checked')?.value;
            
            const isOriginalConfig = (
                currentCategoryId === originalConfig.category_id &&
                currentDayId === originalConfig.day_id
            );

            // Solo restaurar la hora original si estamos en la misma categoría y día originales
            if(isOriginalConfig && originalConfig.hour_id) {
                const originalHourElement = document.querySelector(`[data-hour-id="${originalConfig.hour_id}"]`);
                if(originalHourElement && !originalHourElement.classList.contains("hours__hour--disabled")) {
                    originalHourElement.classList.add("hours__hour--selected");
                    inputHiddenHour.value = originalConfig.hour_id;
                    inputHiddenDay.value = currentDayId;
                }
            }

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