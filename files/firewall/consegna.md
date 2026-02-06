# Consegna

## Componenti della rete

La rete si compone dei seguenti dispositivi:

- Firewall FortiGate
- Switch Cisco
- 2 Raspberry pi
- PC

Un raspberry pi fungerà da server DNS e RDBMS e l'altro da Web-Server.

## Struttura della rete

La rete deve avere 4 vlan:

- VLAN 10: Amministrazione
- VLAN 20: DNS-RDBMS-Server
- VLAN 30: Uffici
- VLAN 40: Web-Server

## Descrizione delle VLAN

Indicazioni generali:

- Tutte le vlan devono essere in grado di accedere a internet.
- Il gateway è l'ultimo indirizzo disponibile della subnet.

### VLAN 10

NET-ID: 192.168.10.0/24

Contiene i computer degli amministratori di sistema.
Questi computer devono poter accedere in ssh a:

- dns-rdbms-server (VLAN 20)
- web-server (VLAN 40)

Questi computer devono poter accedere via https alla GUI del firewall.

### VLAN 20

Contiene il server DNS e RDBMS che sono nello stesso raspberry pi con ip: `192.169.20.1`.
Questo server deve essere accessibile in ssh solo dalla VLAN 10 (Amministrazione) e dalla VLAN 40 (Web-Server).

#### Contenuto del rdbms-server

Il server rdbms deve contenere un database con una tabella.
In questa tabella devono essere salvate le credenziali, username e password, degli utenti che si registrano tramite il web server (VLAN 40).

### VLAN 30

Contiene i computer degli uffici.
Questi computer devono poter accedere al web server (VLAN 40) tramite http e https.
Non possono accedere in ssh a nessun server. Tanto meno alla GUI del firewall.

### VLAN 40

Contiene il web server con ip: `192.169.40.1`.

#### Contenuto del web server

Il web server deve ospitare una pagina web che contiene due pulsanti:

- Login
  Il pulsante fa apparire un form di login con due campi: username e password, e un pulsante "Accedi".
  Appena cliccato il pulsante "Accedi", le credenziali vengono verificate confrontandole con quelle salvate nel database sul dns-rdbms-server (VLAN 20).
  Se le credenziali sono corrette, l'utente viene reindirizzato ad una pagina di benvenuto che mostra "Benvenuto, [username]!".
  Se le credenziali sono errate, viene mostrato un messaggio di errore.
- Registrati
  Il pulsante fa apparire un form di registrazione con tre campi: username, password e ripeti password, e un pulsante "Registrati".
  Appena cliccato il pulsante "Registrati", i dati vengono salvati nel database sul dns-rdbms-server (VLAN 20) solo se le password corrispondono e l'username non è già presente nel database.
  Dopo una registrazione riuscita, l'utente viene reindirizzato alla pagina di login con un messaggio di successo.
  In caso di errore (password non corrispondenti o username già esistente), viene mostrato un messaggio di errore.

## VPN

La rete deve permettere l'accesso remoto sicuro tramite VPN all'intefaccia del firewall e l'accesso in ssh al dns-rdbms-server (VLAN 20) e al web-server (VLAN 40).

## Regole

- WAN -> Web-Server (VLAN 40): consentito solo HTTP e HTTPS
- Uffici (VLAN 30) -> Web-Server (VLAN 40): consentito solo HTTP e HTTPS
- Amministrazione (VLAN 10) -> DNS-RDBMS-Server (VLAN 20): consentito SSH
- Amministrazione (VLAN 10) -> Web-Server (VLAN 40): consentito SSH, HTTP, HTTPS
- Amministrazione (VLAN 10) -> Firewall: consentito HTTPS, SSH

## Stato attuale

Nel firewall sono state create le vlan.
Non sono ancora state create le regole del firewall.

## Domande

Come faccio dalla wan ad accedere al web server?
Come faccio a far comunicare il web server con il database?
Come faccio a configurare il firewall per permettere l'accesso remoto sicuro tramite VPN?
Come faccio a configurare le regole del firewall per permettere solo il traffico necessario tra le VLAN?
