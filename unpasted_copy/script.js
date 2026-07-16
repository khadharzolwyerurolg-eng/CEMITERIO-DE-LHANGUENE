
    // Bloqueia o clique do botão direito
    document.addEventListener('contextmenu', event => event.preventDefault());

    // Bloqueia a ação de copiar (Ctrl + C)
    document.addEventListener('copy', event => {
        event.preventDefault();
        alert('A cópia deste conteúdo não é permitida.');
    });

    // Bloqueia atalhos específicos (Ctrl+C, Ctrl+U, Ctrl+S, F12)
    document.addEventListener('keydown', event => {
        if (
            event.ctrlKey && (event.key === 'c' || event.key === 'u' || event.key === 's') || 
            event.key === 'F12'
        ) {
            event.preventDefault();
        }
    });
