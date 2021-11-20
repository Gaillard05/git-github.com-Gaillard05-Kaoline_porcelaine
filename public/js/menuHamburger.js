let btn = document.getElementById('btnAfficher');
let contenuNav = document.getElementById('navbar');
let iconeBuger = document.querySelector('.bi-list')

btn.addEventListener("click", function () {
    contenuNav.classList.toggle('cache');
    if (!contenuNav.classList.contains('cache')) {
        iconeBuger.classList.toggle('bi-list');
        iconeBuger.classList.add('bi-x-lg');
    } else {
        iconeBuger.classList.toggle('bi-x-lg');
        iconeBuger.classList.add('bi-list');
    }
});


