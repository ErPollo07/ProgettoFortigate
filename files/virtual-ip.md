# Configurazione di un VIP (Virtual IP) su un firewall

Per configurare un Virtual IP su un fortigate si deve navigare nel menu `Policy & Objects` e selezionare la voce `Virtual IPs`.

## Creazione di un VIP

Cliccare su `Create New`.

Per questo progetto è sufficente creare solo un Virtual IP che server per esporre il server web interno alla rete esterna.

## Virtual IP

### Web Server HTTP

- Name: `VIP-Web-Server-HTTP`
- Interface: `wan1` (oppure l'interfaccia collegata alla rete esterna)
- External IP Address/Range: `100.100.100.100` (IP pubblico assegnato all'interfaccia WAN)
- Mapped IP Address/Range: `192.168.40.x` (IP privato del server web interno)
- Abilitare Port Forwarding
- Protocol: `TCP`
- External Service Port: `80` (porta esterna per HTTP)
- Map to Port: `80` (porta interna del server web)

### Web Server HTTPS

- Name: `VIP-Web-Server-HTTPS`
- Interface: `wan1` (oppure l'interfaccia collegata alla rete esterna)
- External IP Address/Range: `100.100.100.100` (IP pubblico assegnato all'interfaccia WAN)
- Mapped IP Address/Range: `192.168.40.x` (IP privato del server web interno)
- Abilitare Port Forwarding
- Protocol: `TCP`
- External Service Port: `443` (porta esterna per HTTP)
- Map to Port: `443` (porta interna del server web)
