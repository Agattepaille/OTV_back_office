$(document).ready(function () {
    var table = $("#otvTable").DataTable({
        retrieve: true,
        destroy: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json",
        },
        fixedHeader: true,
        responsive: true,
        dom: '<"d-flex justify-content-between"lfB>rt<"bottom"ip><"clear">', 

        buttons: [
            {
                extend: 'print',
                text: 'Imprimer',
                title: 'Liste des OTV actives',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6, 10, 11]
                }
            },
        ]
    });

    // Convertir la date du format dd-mm-yyyy au format yyyy-mm-dd
    function convertDateFormat(inputDate) {
        var splitDate = inputDate.split("-");
        if (splitDate.length === 0) {
            return null;
        }

        var year = splitDate[2];
        var month = splitDate[1];
        var day = splitDate[0];

        return new Date(year, month - 1, day);
    }

    // Réinitialiser l'heure de la date à minuit (00:00:00)
    function resetTime(date) {
        if (date) {
            date.setHours(0, 0, 0, 0);
        }
        return date;
    }

    // Définir la fonction de recherche pour filtrer par district, statut et dates
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        var otvStartDate = resetTime(convertDateFormat(data[1]) || new Date(data[1]));
        var otvEndDate = resetTime(convertDateFormat(data[2]) || new Date(data[2]));
        var selectedDistrict = $("#districtFilter").val();
        var selectedStatus = $("#statusFilter").val();
        var startDateFilter = resetTime($('#startDateFilter').val() ? new Date($('#startDateFilter').val()) : null);
        var endDateFilter = resetTime($('#endDateFilter').val() ? new Date($('#endDateFilter').val()) : null);

        // Filtrer par district
        if (selectedDistrict !== "Tous les quartiers") {
            if (data[4] !== selectedDistrict) {
                return false;
            }
        }

        // Filtrer par statut
        if (selectedStatus !== "") {
            if (data[9] !== selectedStatus) {
                return false;
            }
        }

        // Filtrer par intervalle de dates
        if (startDateFilter && otvStartDate < startDateFilter) {
            return false;
        }

        if (endDateFilter && otvEndDate > endDateFilter) {
            return false;
        }

        return true;
    });

    // Appliquer les filtres lorsque les sélecteurs sont modifiés
    $("#districtFilter, #statusFilter, #startDateFilter, #endDateFilter").on("change", function () {
        table.draw();
    });

    // Pour le débogage, affichez les dates filtrées dans la console
    $("#startDateFilter, #endDateFilter").on("change", function () {
        var startDateFilter = $('#startDateFilter').val() ? new Date($('#startDateFilter').val()) : "Aucune date sélectionnée";
        var endDateFilter = $('#endDateFilter').val() ? new Date($('#endDateFilter').val()) : "Aucune date sélectionnée";

        console.log("Date de début du filtre : " + startDateFilter);
        console.log("Date de fin du filtre : " + endDateFilter);
    });
});
