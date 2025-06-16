document.addEventListener('DOMContentLoaded', function() {
    // Для прикладу: плавна прокрутка вгору
    const backButtons = document.querySelectorAll('.btn-back');
    backButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            window.scrollTo({top: 0, behavior: 'smooth'});
        });
    });
});
