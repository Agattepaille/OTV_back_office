document.addEventListener('DOMContentLoaded', function() {
    // Récupérer l'ID de l'OTV
    var id = document.querySelector('#otvId').value;
    console.log('ID de l\'OTV : ' + id);

    // Fonction pour envoyer les modifications au serveur
    function sauvegarderModifications(champ, valeur) {
        fetch(`${id}/edit`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                // 'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                champ: champ,
                valeur: valeur
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                console.log('Modifications enregistrées avec succès !');
            } else {
                console.error('Erreur lors de l\'enregistrement des modifications : ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur lors de l\'enregistrement des modifications : ' + error);
        });
    }

    // Rendre les champs éditables
    function rendreChampsEditables() {
        document.querySelectorAll('input.editable, textarea.editable').forEach(function(element) {
            element.addEventListener('click', function() {
                this.setAttribute('contenteditable', 'true');
            });
        });
    }

    // Appeler la fonction pour rendre les champs éditables au chargement de la page
    rendreChampsEditables();

    // Écouter les modifications sur les champs éditables
    document.querySelectorAll('input.editable, textarea.editable').forEach(function(element) {
        element.addEventListener('blur', function() {
                       console.log('Champ modifié :', this.id, this.value); // Ajout pour débogage

            var champ = this.id; // Supposons que l'ID du champ corresponde au nom de la colonne dans la base de données
            var valeur = this.value; // Nouvelle valeur du champ

            sauvegarderModifications(champ, valeur); // Enregistrer les modifications
        });
    });
});
