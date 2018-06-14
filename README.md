# Pages

* ?action=**login**
* ?action=**register**
* ?action=**home**
* ?action=**customerList**
* ?action=**customerDetail**
* ?action=**productList**
* ?action=**productDetail**
* ?action=**agenda**
* ?action=**command**

# Données envoyées

* **Home** :
    * dailyMeetings : tableau d'objets (place, date, name)
    * monthlyMeetings : tableau d'objets (place, date, name)
    * dailyOrders : tableau d'objets (name, state, date, reference)
    * topCustomers : tableau d'objets (name, id, products (c'est un nombre), restocking (c'est aussi un nombre))
    
* **Agenda** :
    * meetings : tableau d'objets (place, date, name)
    
* **Command** :
    * orders : tableau d'objets (id, name, state, date, reference)
    
* **CustomerDetail** :
    * customer : objet (id, name, location, phone, email, sells (nombre de ventes), difference (pourcentage de différence))
    * reports : tableau d'objets (date, description)
    * orders : tableau d'objets (name, state, date, reference)
    
* **CustomerList** :
    * customers : tableau d'objets (id, name, location, phone, email)
    * prospects : tableau d'objets (id, name, location, phone, email)
    
* **ProductList** :
    * products : tableau d'objets (id, reference, description)