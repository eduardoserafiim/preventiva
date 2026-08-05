document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('comentarioComputador');
    const botaoSalvarComentario = document.getElementById('salvarComentario');
    
    const valorInicial = textarea.value;

    textarea.addEventListener('input', () => {
        if (textarea.value !== valorInicial) 
        {
            botaoSalvarComentario.classList.remove('botaoSalvarComentarios');
        } 
        else 
        {
            botaoSalvarComentario.classList.add('botaoSalvarComentarios');
        }
    });
});