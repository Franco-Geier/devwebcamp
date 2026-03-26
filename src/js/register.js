import Swal from "sweetalert2";

(function() {
    let events = [];

    const summary = document.querySelector("#register-summary");
    if(summary) {
    
        const eventsButton = document.querySelectorAll(".event__add");
        eventsButton.forEach(button => button.addEventListener("click", selectEvent));

        const formRegister = document.querySelector("#register");
        formRegister.addEventListener("submit", submitForm);

        showEvents();

        function selectEvent({target}) {
            if(events.length < 5) {
                target.disabled = true;
                events = [...events, {
                    id: target.dataset.id,
                    title: target.parentElement.querySelector(".event__name").textContent.trim()
                }];
                showEvents();

            } else {
                Swal.fire({
                    title: "Error",
                    text: "Máximo 5 eventos por registro",
                    icon: "error",
                    confirmButtonText: "OK"
                })
            }
        }

        function showEvents() {
            // Limpiar HTML
            cleanEvents();

            if(events.length > 0) {
                events.forEach(event => {
                    const eventDOM = document.createElement("DIV")
                    eventDOM.classList.add("register__event");

                    const title = document.createElement("H3");
                    title.classList.add("register__name");
                    title.textContent = event.title;

                    const deleteBtn = document.createElement("BUTTON");
                    deleteBtn.classList.add("register__delete");
                    deleteBtn.setHTMLUnsafe(`<i class="fa-solid fa-trash"></i>`);
                    deleteBtn.onclick = function() {
                        deleteEvent(event.id);
                    }

                    // Renderizar en el HTML
                    eventDOM.append(title);
                    eventDOM.append(deleteBtn);
                    summary.append(eventDOM);
                })
            } else {
                const noRegister = document.createElement("P");
                noRegister.textContent = "No hay eventos, añade hasta 5";
                noRegister.classList.add("register__text");
                summary.append(noRegister);
            }
        }

        function deleteEvent(id) {
            events = events.filter(event => event.id !== id);
            const addBtn = document.querySelector(`[data-id="${id}"]`);
            addBtn.disabled = false;
            showEvents();
        }

        function cleanEvents() {
            while(summary.firstChild) {
                summary.removeChild(summary.firstChild);
            }
        }

        async function submitForm(e) {
            e.preventDefault();

            // Obtener el regalo
            const giftId = document.querySelector("#gift").value;
            const eventsId = events.map(event => event.id);

            if (eventsId.length === 0 || giftId === "") {
                Swal.fire({
                    title: "Error",
                    text: "Elige al menos un evento y un regalo",
                    icon: "error",
                    confirmButtonText: "OK",
                })
                return;
            }

            // Objeto de FormData
            const data = new FormData();
            data.append("events", eventsId);
            data.append("gift_id", giftId);

            const url = "/end-register/conferences";
            const response = await fetch(url, {
                method: "POST",
                body: data
            });
            const result = await response.json();
            console.log(result);

            if(result.result) {
                Swal.fire(
                    "Registro Exitoso",
                    "Tus conferencias se han almacenado y tu registro fue exitoso, te esperamos en DevWebCamp",
                    "success"
                ).then(() => location.href = `/ticket?id=${result.token}`);
            } else {
                Swal.fire({
                    title: "Error",
                    text: "Hubo un error",
                    icon: "error",
                    confirmButtonText: "OK",
                }).then(() => location.reload());
            }
        }
    }
})();