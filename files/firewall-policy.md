# Firewall policy

Per creare le regole sul firewall è stata utilizzata la seguente strategia.
Sono state create delle policy che permettono il traffico necessario tra le varie VLAN e verso Internet.
Quello che non è permesso viene bloccato dalla regola implicita di default "deny all".
Sono state create delle regole specifiche per bloccare l'accesso dalla VLAN degli Uffici (VLAN30) e dalla WAN, verso le VLAN più sensibili (Amministrazione e DNS-RDBMS Server) e verso il firewall stesso.

## Configurazione di una policy via GUI

Passaggi per la configurazione di una policy via GUI:

1. Policy & Objects -> Firewall Policy → Create New
2. Name: "VLAN30-to-Internet"
3. Incoming Interface: vlan30
4. Outgoing Interface: wan1
5. Source: VLAN30-subnet (10.10.30.0/24)
6. Destination: all
7. Service: ALL (o seleziona HTTP, HTTPS, DNS, NTP se vuoi limitare)
8. Action: ACCEPT
9. NAT: Enable
10. Log Allowed Traffic: All Sessions

## Regole

### WAN

#### WAN → Web Server

Name: WAN-to-WebServer
Incoming Interface: wan1
Outgoing Interface: vlan40
Source: + all
Destination: + WebServer-VIP
Schedule: always
Service: + HTTP, + HTTPS
Action: ✅ ACCEPT

NAT: ✅ ATTIVO
IP Pool: Use Outgoing Interface Address
Log Allowed Traffic: All Sessions

#### WAN → DNS-RDBMS Server (BLOCCO)

#### WAN → Amministrazione (BLOCCO)

Name: WAN-to-Admin
Incoming Interface: wan1
Outgoing Interface: vlan10
Source: + all
Destination: + WebServer-VIP
Schedule: always
Service: + HTTP, + HTTPS
Action: ✅ ACCEPT

NAT: ✅ ATTIVO
IP Pool: Use Outgoing Interface Address
Log Allowed Traffic: All Sessions

### Amministrazione

#### Amministrazione → DNS-RDBMS Server (SSH)

Name: Admin-SSH-to-DBServer
Incoming Interface: vlan10
Outgoing Interface: vlan20
Source: + VLAN10-subnet
Destination: + DNS-RDBMS-Server
Schedule: always
Service: + SSH
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### Amministrazione → Web Server

Name: Admin-to-WebServer
Incoming Interface: vlan10
Outgoing Interface: vlan40
Source: + VLAN10-subnet
Destination: + WebServer
Schedule: always
Service: + SSH, + HTTP, + HTTPS
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### Amministrazione → Firewall GUI

Name: Admin-to-Firewall
Incoming Interface: vlan10
Outgoing Interface: any (o lascia vuoto se chiede)
Source: + VLAN10-subnet
Destination: + Firewall-Management (IP del firewall)
Schedule: always
Service: + HTTPS, + SSH
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions
Nota: Se "Destination" non accetta l'IP del firewall, puoi usare "all" o creare un oggetto address con l'IP di management del FortiGate.

#### Amministrazione → Internet

Name: Admin-to-Internet
Incoming Interface: vlan10
Outgoing Interface: wan1 (o port1)
Source: + VLAN10-subnet
Destination: + all
Schedule: always
Service: + ALL
Action: ✅ ACCEPT

NAT: ✅ ATTIVO
IP Pool: Use Outgoing Interface Address
Log Allowed Traffic: All Sessions

### DNS-RDBMS Server

#### DNS-RDBMS Server → Internet

Name: DBServer-to-Internet
Incoming Interface: vlan20
Outgoing Interface: wan1 (o port1)
Source: + VLAN20-subnet
Destination: + all
Schedule: always
Service: + ALL
Action: ✅ ACCEPT

NAT: ✅ ATTIVO
IP Pool: Use Outgoing Interface Address
Log Allowed Traffic: All Sessions

### Uffici

#### Uffici → Web Server

Name: Uffici-to-WebServer
Incoming Interface: vlan30
Outgoing Interface: vlan40
Source: + VLAN30-subnet
Destination: + WebServer
Schedule: always
Service: + HTTP, + HTTPS
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### Uffici → Internet

Name: Uffici-to-Internet
Incoming Interface: vlan30
Outgoing Interface: wan1 (o port1)
Source: + VLAN30-subnet
Destination: + all
Schedule: always
Service: + ALL
Action: ✅ ACCEPT

NAT: ✅ ATTIVO
IP Pool: Use Outgoing Interface Address
Log Allowed Traffic: All Sessions

#### Uffici → Amministrazione (BLOCCO)

Name: Block-Uffici-to-Admin
Incoming Interface: vlan30
Outgoing Interface: vlan10
Source: + VLAN30-subnet
Destination: + all
Schedule: always
Service: + ALL
Action: ❌ DENY

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### Uffici → DNS-RDBMS Server (BLOCCO)

Name: Block-Uffici-to-DBServer
Incoming Interface: vlan30
Outgoing Interface: vlan20
Source: + VLAN30-subnet
Destination: + all
Schedule: always
Service: + ALL
Action: ❌ DENY

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### Uffici → Firewall (BLOCCO)

Name: Block-Uffici-to-Firewall
Incoming Interface: vlan30
Outgoing Interface: any (o root)
Source: + VLAN30-subnet
Destination: + Firewall-Management
Schedule: always
Service: + ALL
Action: ❌ DENY

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions
Nota: Questa regola potrebbe non essere necessaria se il FortiGate ha già regole di management implicite.

### WEB Server

#### Web Server → DNS-RDBMS Server

Name: WebServer-to-DBServer
Incoming Interface: vlan40
Outgoing Interface: vlan20
Source: + WebServer
Destination: + DNS-RDBMS-Server
Schedule: always
Service: + SSH, + MYSQL
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### Web Server → Internet

Name: WebServer-to-Internet
Incoming Interface: vlan40
Outgoing Interface: wan1 (o port1)
Source: + VLAN40-subnet
Destination: + all
Schedule: always
Service: + ALL
Action: ✅ ACCEPT

NAT: ✅ ATTIVO
IP Pool: Use Outgoing Interface Address
Log Allowed Traffic: All Sessions

### VPN

#### VPN → Firewall

Name: VPN-to-Firewall
Incoming Interface: ssl.root (o ssl-vpn interface)
Outgoing Interface: any (o root)
Source: + SSL-VPN_TUNNEL_ADDR1 (pool VPN)
Destination: + Firewall-Management
Schedule: always
Service: + HTTPS, + SSH
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions
Nota: Configura prima la VPN SSL, poi crea questa regola. L'oggetto "SSL-VPN_TUNNEL_ADDR1" viene creato automaticamente dal FortiGate quando configuri la VPN.

#### VPN → DNS-RDBMS Server

Name: VPN-to-DBServer
Incoming Interface: ssl.root (o ssl-vpn interface)
Outgoing Interface: vlan20
Source: + SSL-VPN_TUNNEL_ADDR1
Destination: + DNS-RDBMS-Server
Schedule: always
Service: + SSH
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### VPN → Web Server

Name: VPN-to-WebServer
Incoming Interface: ssl.root (o ssl-vpn interface)
Outgoing Interface: vlan40
Source: + SSL-VPN_TUNNEL_ADDR1
Destination: + WebServer
Schedule: always
Service: + SSH
Action: ✅ ACCEPT

NAT: ❌ DISATTIVO
Log Allowed Traffic: All Sessions

#### VPN → Internet (OPZIONALE)

Name: VPN-to-Internet
Incoming Interface: ssl.root (o ssl-vpn interface)
Outgoing Interface: wan1 (o port1)
Source: + SSL-VPN_TUNNEL_ADDR1
Destination: + all
Schedule: always
Service: + ALL
Action: ✅ ACCEPT

NAT: ✅ ATTIVO
IP Pool: Use Outgoing Interface Address
Log Allowed Traffic: All Sessions
