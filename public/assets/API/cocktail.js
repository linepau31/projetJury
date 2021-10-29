function letterPagination(letter) {
    let url = 'https://www.thecocktaildb.com/api/json/v1/1/search.php?f=';
    writeToDocument(url + letter);
}
async function callApi(url) {
    let response = await fetch(url);
    return await response.json();
}

function writeToDocument(url) {
    let tableRows = [];
    let el = document.getElementById("data");
    callApi(url).then(function (response) {
        data = response.drinks;
        data.forEach(function (item) {
            let dataRow = [];
            dataRow.push('<div class="col-sm-12 col-md-6 col-lg-3 d-flex flex-row justify-content-center">');
            dataRow.push('<div class="card shadow-lg p-2 mb-3 bg-white rounded mt-3">');
            dataRow.push('<div class="image">');
            dataRow.push(`<img src=${item.strDrinkThumb} class="img-fluid" onclick="openGalleryModal(${item.idDrink})">`);
            dataRow.push('</div>');
            dataRow.push('<div class="card-body">');
            dataRow.push(`<h3 class="card-title">${item.strDrink}</h3>`);
            dataRow.push(`<h6 class="card-alcoholic">${item.strAlcoholic}</h6>`);
            dataRow.push('</div>');
            dataRow.push('</div>');
            dataRow.push('</div>');
            tableRows.push(`${dataRow}`);
        });

        el.innerHTML = `${tableRows}`.replace(/,/g, "");
    }).catch(function (err) {
        $('#modalMissing').modal('show');
    });
 ;
}

function openGalleryModal(id) {

    let url = 'https://www.thecocktaildb.com/api/json/v1/1/lookup.php?i=';
    writeToModal(url + id);
    $('#modalDetails').modal('show');

}

function writeToModal(url) {
    let tableRowsBody = [];
    let el = document.getElementById("modal-cocktail");

    callApi(url).then(function (response) {
        data = response.drinks;

        data.forEach(function (item) {
            let dataRow = [];
            dataRow.push(`<img src=${item.strDrinkThumb} class="img-fluid">`);
            dataRow.push(`<p><bold>Glass: </bold>${item.strGlass}</p>`);
            dataRow.push(`<p><bold>Category: </bold>${item.strCategory}</p>`);
            dataRow.push(`<p><bold>Ingredients: </bold> <ul style="list-style-type:disc;"></p>`);

            const ingredient = [{
                "ingredient": item.strIngredient1,
                "measure": item.strMeasure1
            }, {
                "ingredient": item.strIngredient2,
                "measure": item.strMeasure2
            }, {
                "ingredient": item.strIngredient3,
                "measure": item.strMeasure3
            }, {
                "ingredient": item.strIngredient4,
                "measure": item.strMeasure4
            }, {
                "ingredient": item.strIngredient5,
                "measure": item.strMeasure5
            }, {
                "ingredient": item.strIngredient6,
                "measure": item.strMeasure6
            }, {
                "ingredient": item.strIngredient7,
                "measure": item.strMeasure7
            }, {
                "ingredient": item.strIngredient8,
                "measure": item.strMeasure8
            }, {
                "ingredient": item.strIngredient9,
                "measure": item.strMeasure9
            }];

            ingredient.forEach(pushIngredient);

            function pushIngredient(item) {
                if (item.ingredient !== null) {
                    if (item.measure !== null) {
                        dataRow.push(`<li>${item.measure} of ${item.ingredient}</li>`);
                    } else {
                        dataRow.push(`<li>${item.ingredient}</li>`);
                    }
                }
            }

            dataRow.push(`</ul>`);
            tableRowsBody.push(`${dataRow}`);
        });

        el.innerHTML = `${tableRowsBody}`.replace(/,/g, "");

    });

    let tableRowsHeader = [];
    let title = document.getElementById("modal-cocktail-header");

    callApi(url).then(function (response) {
        data = response.drinks;
        data.forEach(function (item) {
            var dataRow = [];
            dataRow.push(`<h3 class="modal-title">${item.strDrink}</h3>`);
            tableRowsHeader.push(`${dataRow}`);
        });

        title.innerHTML = `${tableRowsHeader}`.replace(/,/g, "");

    });
}



