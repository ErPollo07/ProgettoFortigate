# Firewall policy

Per creare le regole sul firewall è stata utilizzata la seguente strategia.
Sono state create delle policy che permettono il traffico necessario tra le varie VLAN e verso Internet.
Quello che non è permesso viene bloccato dalla regola implicita di default "deny all".
Sono state create delle regole specifiche per bloccare l'accesso dalla VLAN degli Uffici (VLAN30) e dalla WAN, verso le VLAN più sensibili (Amministrazione e DNS-RDBMS Server) e verso il firewall stesso.

## Regole nuove

### WAN

-> Web Server: HTTPS, HTTP
-> Vlan 10: BLOCCO TUTTO IL TRAFFICO
-> Vlan 20: BLOCCO TUTTO IL TRAFFICO
-> Vlan 30: BLOCCO TUTTO IL TRAFFICO
-> Vlan 40: BLOCCO TUTTO IL TRAFFICO

### Vlan 10

-> DNS-RDBMS Server: SSH, DNS
-> Web Server: SSH, HTTP, HTTPS
-> Vlan 20: Ping
-> Vlan 30: Ping
-> Vlan 40: Ping
-> Internet: ALL

### Vlan 20

-> DNS-RDBMS Server: DNS
-> Web Server: HTTP, HTTPS
-> Vlan 10: Ping
-> Vlan 30: Ping
-> Vlan 40: Ping
-> Internet: ALL

### Vlan 30

-> DNS-RDBMS Server: DNS
-> Web Server: HTTP, HTTPS
-> Vlan 10: BLOCCO TUTTO IL TRAFFICO
-> Vlan 20: Ping (BLOCCO)
-> Vlan 40: Ping (BLOCCO)
-> Internet: ALL

### Vlan 40

-> DNS-RDBMS Server: DNS, SSH, MYSQL
-> Web Server: HTTP, HTTPS
-> Vlan 10: Ping
-> Vlan 20: Ping
-> Vlan 30: Ping
-> Internet: ALL

## Creazione di Source e Destination

Per creare la source di una subnet:

1. Cliccare su `Create New` → `Address`
2. Inserire il nome
3. Selezionare `Subnet` come Type
4. Inserire l'indirizzo IP e la subnet mask

Per creare la source di un singolo IP (es. server):

1. Cliccare su `Create New` → `Address`
2. Inserire il nome
3. Selezionare `Subnet` come Type
4. Inserire l'indirizzo IP del singolo host con subnet mask: `255.255.255.255`
