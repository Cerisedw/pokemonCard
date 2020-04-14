// mes fonctions axios delete
const getIdDeck = (e) => {
    let iddeckString;
    if(e.target.id === ""){
        iddeckString = $(e.target).parent().attr('id');
    }else{
        iddeckString = e.target.id;
    }
    const iddeck = parseInt(iddeckString.slice(4));
    return iddeck;
}

const deleteDeck = (e) => {
    const idDeck = getIdDeck(e);
    const form = new FormData();
    form.append('iddeck', idDeck);
    let url = Routing.generate('delete-deck');

    axios.post(url, form)
    .then($(`#${idDeck}`).empty())
    .catch((error) => console.log(error));
}




// on click delete
const btnDeleteList = $('.deleteDeckBtn');
$.makeArray(btnDeleteList).forEach((btn) => {
    $(btn).on('click', deleteDeck);
});