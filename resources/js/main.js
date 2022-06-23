$(function(){
    $('.player-list').click(function(){
        let playerCard = $(this).data('playerselection');
        $('.player-cards').hide();
        let teamColor = $('#' + playerCard).css("border-top-color")
        $('#' + playerCard).show();
        $('#title').css('color',teamColor);
    });

});