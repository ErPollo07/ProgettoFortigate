# Configurazione di un VIP (Virtual IP) su un firewall

Per configurare un Virtual IP su un fortigate si deve navigare nel menu `Policy & Objects` e selezionare la voce `Virtual IPs`.

## Creazione di un VIP

Cliccare su `Create New`.

Per questo progetto è sufficente creare solo un Virtual IP che server per esporre il server web interno alla rete esterna.

## Virtual IP

### Web Server HTTP

- Name: `vip-web-server-http`
- Interface: `wan1` (oppure l'interfaccia collegata alla rete esterna)
- External IP Address/Range: `100.100.100.100` (IP pubblico assegnato all'interfaccia WAN)
- Mapped IP Address/Range: `192.168.40.x` (IP privato del server web interno)
- Abilitare Port Forwarding
- Protocol: `TCP`
- External Service Port: `80` (porta esterna per HTTP)
- Map to Port: `80` (porta interna del server web)

### Web Server HTTPS

- Name: `vip-web-server-https`
- Interface: `wan1` (oppure l'interfaccia collegata alla rete esterna)
- External IP Address/Range: `100.100.100.100` (IP pubblico assegnato all'interfaccia WAN)
- Mapped IP Address/Range: `192.168.40.x` (IP privato del server web interno)
- Abilitare Port Forwarding
- Protocol: `TCP`
- External Service Port: `443` (porta esterna per HTTP)
- Map to Port: `443` (porta interna del server web)


## Virutal IP group

Creare un Virtual IP Group per raggruppare i due VIP creati in precedenza.

- Name: `vip-web-server`
- Interface: `wan1` (oppure l'interfaccia collegata alla rete esterna)
- Members: selezionare `vip-web-server-http` e `vip-web-server-https`