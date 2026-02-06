# Firewall policy

Per creare le regole sul firewall è stata utilizzata la seguente strategia.
Sono state create delle policy che permettono il traffico necessario tra le varie VLAN e verso Internet.
Quello che non è permesso viene bloccato dalla regola implicita di default "deny all".
Sono state create delle regole specifiche per bloccare l'accesso dalla VLAN degli Uffici (VLAN30) e dalla WAN, verso le VLAN più sensibili (Amministrazione e DNS-RDBMS Server) e verso il firewall stesso.

```txt

config firewall policy
    edit 2
        set name "BLOCK-WAN-to-AllVLANs"
        set srcintf "port1"
        set dstintf "port1" "port2"
        set srcaddr "all"
        set dstaddr "all"
        set action deny
        set schedule "always"
        set service "ALL"
        set logtraffic all
        set comments "Blocco totale da WAN verso VLAN interne"
    next
end
```

## Regole

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

## Regole in ordine



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
