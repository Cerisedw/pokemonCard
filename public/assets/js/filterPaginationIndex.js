const newPagination = (maxPage) => {
    const maxPagenmb = (maxPage === 0) ? 1 : maxPage;
    $('.pagination').empty();
    $('.pagination').append(`<li class="waves-effect disabled"><a><i class="material-icons" id='back'>chevron_left</i></a></li>`);
    for(let i = 0; i < maxPagenmb; i++){
        if(i === 0){
            $('.pagination').append(`<li class="active waves-effect"><a id='page${i + 1}'>${i + 1}</a></li>`);
        }else {
            $('.pagination').append(`<li class="waves-effect"><a id='page${i + 1}'>${i + 1}</a></li>`);
        }
    }
    $('.pagination').append(`<li class="waves-effect"><a><i class="material-icons" id='after'>chevron_right</i></a></li>`);
};


const putPaginationJs = (pageMax, idtype) => {
    const form2 = new FormData();
    const li = $('.pagination li');
    $.makeArray(li).forEach((item) => {
        $(item).on("click", (p) => {
            const idtarget = getIdTarget(p);
            if(pageMax >= idtarget && idtarget != 0){
                form2.append('page', idtarget);
                let url = Routing.generate('card-pagination-type', {'idtype' : idtype});
                axios.post(url, form2)
                .then((res) => {
                    pageChangeDisplay(idtarget, pageMax);
                    constructList(res.data);
                })
                .catch((error) => console.log(error));
            }
        });
    });
    $('.dropdown-trigger').dropdown();
}

const idDeck = $('#deckActuel').attr('value');

const filterbtn = $('.filter');
$.makeArray(filterbtn).forEach((item) => {
    $(item).on("click", (x) => {
        const idtype = x.target.id.slice(4);
        const form = new FormData();
        const url = Routing.generate('card-maxpage-type', {'idtype': idtype});
        axios.post(url, form)
        .then((res) => {
            const nmbPage = res.data;
            newPagination(nmbPage);
            putPaginationJs(nmbPage, idtype);
        })
        .catch((error) => console.log(error));
    });
});
