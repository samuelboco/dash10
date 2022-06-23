/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!******************************!*\
  !*** ./resources/js/main.js ***!
  \******************************/
$(function () {
  $('.player-list').click(function () {
    var playerCard = $(this).data('playerselection');
    $('.player-cards').hide();
    console.log(playerCard);
    var teamColor = $('#' + playerCard).css("border-top-color");
    console.log(teamColor);
    $('#' + playerCard).show();
    $('#title').css('color', teamColor);
  });
});
/******/ })()
;