<?php
$templateParams = [
    'pageTitle' => 'Privacy Policy',
    'sections' => [
        [
            'title' => '1. Introduzione',
            'text' => 'UniMatch ("noi", "nostro" o "ci") si impegna a proteggere la privacy dei propri utenti. La presente Privacy Policy descrive come raccogliamo, utilizziamo e proteggiamo le informazioni personali.'
        ],
        [
            'title' => '2. Informazioni raccolte',
            'text' => 'Raccogliamo le seguenti informazioni:',
            'list' => [
                'Informazioni di account: nome, email, password (criptata)',
                'Informazioni di utilizzo: log di accesso, attività sulla piattaforma',
                'Informazioni tecniche: indirizzo IP, tipo di browser, sistema operativo'
            ]
        ],
        [
            'title' => '3. Utilizzo delle informazioni',
            'text' => 'Utilizziamo le tue informazioni per:',
            'list' => [
                'Fornire e migliorare i nostri servizi',
                'Comunicare con te riguardo al tuo account',
                'Personalizzare la tua esperienza',
                'Garantire la sicurezza della piattaforma'
            ]
        ],
        [
            'title' => '4. Condivisione dei dati',
            'text' => 'Non vendiamo né condividiamo i tuoi dati personali con terze parti, eccetto nei seguenti casi:',
            'list' => [
                'Con il tuo consenso esplicito',
                'Per rispettare obblighi legali',
                'Per proteggere i diritti e la sicurezza di UniMatch e dei suoi utenti'
            ]
        ],
        [
            'title' => '5. Sicurezza',
            'text' => 'Implementiamo misure di sicurezza appropriate per proteggere i tuoi dati personali da accessi non autorizzati, alterazioni, divulgazioni o distruzioni.'
        ],
        [
            'title' => '6. I tuoi diritti',
            'text' => 'Hai il diritto di:',
            'list' => [
                'Accedere ai tuoi dati personali',
                'Correggere dati inesatti',
                'Richiedere la cancellazione dei tuoi dati',
                'Opporti al trattamento dei tuoi dati',
                'Richiedere la portabilità dei dati'
            ]
        ],
        [
            'title' => '7. Cookie',
            'text' => 'Utilizziamo cookie e tecnologie simili per migliorare la tua esperienza. Puoi gestire le preferenze dei cookie tramite le impostazioni del tuo browser.'
        ],
        [
            'title' => '8. Modifiche alla Privacy Policy',
            'text' => 'Ci riserviamo il diritto di modificare questa Privacy Policy in qualsiasi momento. Le modifiche saranno pubblicate su questa pagina con una nuova data di aggiornamento.'
        ],
        [
            'title' => '9. Contatti',
            'text' => 'Per domande riguardanti questa Privacy Policy, contattaci a:',
            'email' => 'privacy@unimatch.com'
        ]
    ]
];

include 'template/info-base.php';
