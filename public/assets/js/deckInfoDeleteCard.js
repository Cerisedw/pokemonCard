const jsonRequestAddCard = (iddeck, idcard, evtarget) => {
    const form = new FormData();
    form.append('iddeck', iddeck);
    form.append('idcard', idcard);
    let url = Routing.generate('delete-card-to-deck');
    axios.post(url, form)
    .then((res) => {
        $(`#${idcard}`).parent().parent().empty();
    })
    .catch((error) => console.log(error));;
};

const deleteCard = (e)=>{
    // console.log(e.target);
    const arrayString = $(e.target).attr('id').split(" ");
    const cardId = parseInt(arrayString["0"].slice(4));
    const deckId = parseInt(arrayString["1"].slice(4));
    jsonRequestAddCard(deckId, cardId, e.target);
    // console.log(deckId);
    // console.log(cardId);
};



const idDeck = $('#deckActuel').attr('value');

const btnDeleteCard = $('.btnDeleteCard');
$.makeArray(btnDeleteCard).forEach((item) => {
    $(item).on("click", deleteCard);
});

