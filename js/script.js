document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('rsvp-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const nomeInput = document.getElementById('nome_completo');
            const errorMsg = document.getElementById('name-error');
            const btnText = document.getElementById('btn-text');
            const btn = document.getElementById('btn-confirmar');
            
            // Reset error message
            errorMsg.textContent = '';
            
            // Validate input
            if (nomeInput.value.trim() === '') {
                e.preventDefault();
                errorMsg.textContent = 'Por favor, preencha seu nome completo.';
                nomeInput.focus();
                return;
            }

            // Visual feedback on submit
            btn.disabled = true;
            btnText.textContent = 'Enviando...';
        });
    }
});
