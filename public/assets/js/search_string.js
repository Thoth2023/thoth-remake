async function related_terms(term){
    const div = document.getElementById("related-terms");
    div.innerHTML = "";
    const final_terms = await getRelatedTerms(term);
    if(!final_terms)
        return;
    for(let i = 0; i < final_terms.length; i++){
        const divinp = document.createElement('div');
        divinp.className = 'input-group ';
        divinp.className += 'col-md-1 ';
        // divinp.className += 'offset-md-2 ';

        const inp = document.createElement('input');
        inp.value = final_terms[i];
        inp.className = "form-control";

        const append = document.createElement('div');
        append.className = "input-group-append";

        const btn = document.createElement('button');
        btn.type = "button";
        btn.className = "btn btn-primary";
        btn.style.marginTop = "5px";

        btn.onclick = () => {
            add_synonym(final_terms[i]);
            divinp.remove();
        };

        const add = document.createElement('span');
        add.className = "fas fa-plus";

        btn.appendChild(add);

        append.appendChild(btn);

        divinp.appendChild(inp);
        divinp.appendChild(append);
        div.appendChild(divinp);
    }
}
