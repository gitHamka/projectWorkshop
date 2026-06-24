document.querySelectorAll('.faq-question').forEach(function(question) {
    question.addEventListener('click', function() {
        var item   = this.closest('.faq-item');
        var answer = item.querySelector('.faq-answer');
        var btn    = item.querySelector('.faq-toggle');
        var isOpen = item.classList.contains('active');

        // close all
        document.querySelectorAll('.faq-item').forEach(function(i) {
            i.classList.remove('active');
            i.querySelector('.faq-toggle').textContent = '+';
        });

        // open if semua close
        if (!isOpen) {
            item.classList.add('active');
            btn.textContent = '×';
        }
    });
});
