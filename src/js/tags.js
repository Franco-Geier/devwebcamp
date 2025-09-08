(function() {
    const tagsInput = document.querySelector("#tags_input");

    if(tagsInput) {
        const tagsDiv = document.querySelector("#tags");
        const tagsInputHidden = document.querySelector('[name="tags"]')
        let tags = [];
        
        // Recuperar del input oculto
        if(tagsInputHidden.value !== "" && tagsInputHidden.value.trim() !== "") {
            tags = tagsInputHidden.value.split(",");
            showTags();
        }

        tagsInput.addEventListener("keypress", saveTag);

        function saveTag(e) {
            if(e.keyCode === 44) {
                e.preventDefault();
                if(e.target.value.trim() === "" || e.target.value < 1){
                    return
                }

                tags = [...tags, e.target.value.trim()];
                tagsInput.value = "";  
                showTags();
            }
        }

        function showTags() {
            tagsDiv.textContent = "";
            tags.forEach(tmpTag =>{
                const tag = document.createElement("LI");
                tag.classList.add("form__tag");
                tag.textContent = tmpTag;
                tag.onclick = deleteTag;
                tagsDiv.append(tag);
            })

            updateInputHidden();
        }

        function deleteTag(e) {
            e.target.remove();
            tags = tags.filter(tag => tag !== e.target.textContent);
            updateInputHidden();
        }

        function updateInputHidden() {
            tagsInputHidden.value = tags.toString();
        }
    }
})() // IIFE