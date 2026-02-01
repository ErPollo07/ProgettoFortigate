# Configurazione VLAN

In questo file sono illustrati i passaggi necessari per configurare una VLAN (Virtual Local Area Network) su un Fortigate.

## Passaggi per Configurare una VLAN

1. **Dashboard di Fortigate**
Accedi al dashboard del tuo dispositivo Fortigate utilizzando le credenziali amministrative.

2. **Creazione dell'interfaccia**
Per creare l'interfaccia VLAN si deve andare su:

- Menu di sinistra: `Network` > `Interfaces`
- Clicca su `Create New` e seleziona `Interface`.

3. **Configurazione dell'interfaccia VLAN**
Ecco la configurazione per ogni vlan:

- **VLAN 10**:
  - Name: `Amministrazione`
  - Alias: `mng`
  - Interface: `port2`
  - VLAN ID: `10`
  - IP/Netmask: `192.168.10.254/255.255.255.0`
  - Administrative Access: `ping`, `https`, (copiare da l'interfaccia port1)
  - DHCP Server: `Enabled`
    - IP range: `192.168.10.50-192.168.10.200`
- **VLAN 20**:
  - Name: `DNS-RDBSM-Server`
  - Alias: `dns-rdbsm-server`
  - Interface: `port2`
  - VLAN ID: `20`
  - IP/Netmask: `192.168.20.254/255.255.255.0`
  - Administrative Access: nessuno
  - DHCP Server: `Enabled`
    - IP range: `192.168.20.50-192.168.20.200`
- **VLAN 30**:
  - Name: `Uffici`
  - Alias: `uffici`
  - Interface: `port2`
  - VLAN ID: `30`
  - IP/Netmask: `192.168.30.254/255.255.255.0`
  - Administrative Access: nessuno
  - DHCP Server: `Enabled`
    - IP range: `192.168.30.50-192.168.30.200`
- **VLAN 40**:
  - Name: `WEB-Server`
  - Alias: `web-server`
  - Interface: `port3`
  - VLAN ID: `40`
  - IP/Netmask: `192.168.40.254/255.255.255.0`
  - Administrative Access: nessuno
  - DHCP Server: `Enabled`
    - IP range: `192.168.40.50-192.168.40.200`
