let image = document.getElementById("produits");

let main = document.getElementById("main");

image.addEventListener("click", afficherModal);

function afficherModal() {
    let div = document.createElement("div");

    let p = document.createElement("p");

    div.appendChild(p);

    main.appendChild(div);

}
