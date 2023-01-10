let allmax = [<?= '1, 2, 5, 3, 2' ?>]
$('.answer').each(function(index, elem){$(this).data('maxanswers', allmax[index])})
$('input[type="checkbox"]').click(function(){
    let closest_answer = $(this).closest('.answer');
    let max_allowed = closest_answer.data('maxanswers');
    console.log(max_allowed);
});
