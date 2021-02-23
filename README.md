# Progetto Cubes Bolla - Populous 1989 world editing and small god action
	
![Image Preview](/preview/preview.png)
	
## Avvertenze
	
	Su Opera non si garantisce il corretto funzionamento del puntatore del mouse.
	Su chrome e firefox si garantisce il funzionamento del puntatore del mouse se gli fps sono maggiori di 15.

## Report

Il progetto ripropone il gestore del mondo di populous semplificato in chiave voxel con alcune capacità divine, quali il
terremoto, lo tzunami e la meteorite.  
Vi è inoltre la presenza di un Camminatore Errante, immortale, e incapace di nuotare, difatto quando dovesse cadere in acqua profonda si 
trasporterebbe magicamente da un altra parte.

#### Interfaccia

L' interfaccia si compone di un tastierino sulla sinistra con le seguenti feature dal alto-sinistro muovendosi per righe crescenti:
	
* 8 bottoni direzionali per muoversi nelle varie direzione (se fine mappa non si muove)
	
	![Image arrow](/textures/arrows.png)
	
* bottone per trovare il Camminatore Errante

	![Image arrow](/textures/punto.png)

* 2 bottoni per gestire l'altezza terreno

	![Image alza](/textures/alza.png) ![Image bassa](/textures/bassa.png)

* bottone potere terremoto

	![Image trremoto](/textures/terremoto.png)

* bottoni per lo zoom

	![Image piu](/textures/piu.png) ![Image meno](/textures/meno.png)

* bottoni per ruotare la mappa

	![Image Clock](/textures/Clock.png) ![Image AClock](/textures/AClock.png)

* bottone potere tzunami

	![Image wave](/textures/wave.png)

* bottone potere meteorite

	![Image meteora](/textures/meterora.png)

sulla destra una bussola che indica la posizione, il tutto su un tavolo al cui centro si può vedere la mappa dela mondo modificabile.  
Premendo WASD si va a interagire con la posizione mentre con Q ed E si ruota e con + e - si effettua uno zoom


#### Poteri

* altezza Terreno:
	si può alzare o abassare il terreno andando a premere i bottoni adeguati e cliccando poi la mappa

* Terremoto:
	il Terremoto va a modificare l'aspetto del terreno alzando e abassando l'altezza massima dei blocchi con una semplice 
	animazione di tutta la mappa al centro, simulando un terremoto ondulatorio

* Tzunami:
	lo Tzunami va ad alzare l'acqua con una mappa a punti,non interferisce in nessun modo con il terreno ma ha solo
	carattere grafico

* Meteora:
	la Meteora crea un meteorite che va a inpattarsi con il terreno ove si è cliccato dopo averlo selezionato, all'impatto
	genera un cratere di dimensioni circa 6x6 di profonidità 3, modificando il terreno

#### journal

* 28/10/19:
	* Progettazione idea simil populous  
	* Studio funzionamento HeightMap, implementazione  
	
* 29/10/19:
	* Implementazione del "crop" nel terreno del mondo  
		* initiateTerrain()  :  inizializza la mappa  
		* updateTerrainVis() :  passa alla scena solo il terreno "utile"  
		* onDocumentKeyDown():  input della tastiera per muovere il "crop" della mappa  
	* uso della camera ortogonale  
	* resize del renderer al resize schermo  
		* onWindowResize()   : resize view  
	* La mappa si muove al premere dei btn WASD sino al bordo  

* 30/10/19:
	* Implemetazione shader material sabbia  
		* con luccichio e ombra posizionale non trasmessa  

* 31/10/19:
	* Implemetazione shader material erba  
		* con ombra posizionale non trasmessa e movimento  
	* Implemetazione shader material acqua  
		* con luccichio e movimento  
	* Implemetazione shader material neve  
		* con luccichio e ombra posizionale non trasmessa  
	* materiale(posY) : setta materiale in base all'altezza  

* 1/11/19:
	* Aggiunta bottoni comando x posizione  
		* initiateButton() : posizione
	* Implementazione funzione per alzare o abassare il terreno e bottoni per controllarlo  
		* modifyTerrainHigh(position,value) : aumenta altezza terreno in posizione position di un valore value
		* onDocumentMouseMove()	: per estrapolare posizione mouse
		* onDocumentMouseUp()   : per quando si lascia il bottone
		* onDocumentMouseDown() : per intercettare cosa si clicca sullo schermo
		* initiateButton()		: add, subtruct height  
	* aggiunti btn per terremoto, tzunami(errore di alpha), meteorite(ancora non implementato)  
		* terremotoAction()	: gestione terremoto
		* waveAction()		: gestione tzunami
		* initiateButton()  : terremoto, tzunami e meteorite
	* rotazione con correzione di direzione e zoom in/out  
		* initiateButton()  : +, - per lo zoom
	* vertexWater  tzunami ma errore alpha  
		
	
* 2/11/19:
	* correzione alpha dello tzunami e suo aspetto  
	* implementazione meteorite senza texture con funzionalità del impatto  
		* meteoraAction(positione) : gestore meteora data la posizione di dove dovra colpire
	* correzione direzione   
		* directionAction(dir) : gestione direzioe data la rotazione (0 = north, 1 = north-est, 2 = est, ... , 6 = west, 7 = nort-west)
				
* 3/11/19
	* aggiunta bussola con direzione  

* 4/11/19
	* Implemetato fasi giorno notte, con passaggio poco sfumato  
	* implementato orologio in alto a sinistra per fasi giorno  
	* correzione bug di shader  
	
* 5/11/19
	* bug direzione sfalsata
	* implementato effetto esplosione con fragment e vertex, e oggetto esplosione
		* meteoraAction(positione) : crea anche l'intervallo per gestire l'animazione delle esplosioni
	* implementato shader meteora
	* correzione colori
	* la mappa ruota al premere di Q(orario), E(antiorario)
	
* 6/11/19:
	* implementato camminatore errante nella mappa	
		* Entity(model) : crea il un entity dato un modello (Mesh+Armature)

* 7/11/19:
	* implementata animazione camminatore errante
	* aggiunto bottone per centrare il camminatore
		* puntaCamminatore() : sposta il cropWorld per mostrare il camminatore
	* correzione movimento camminatore ("no in acqua" e no camminata oltre 2 blocchi altezza)
	* implementato un loadState per controllare lo stato del caricamento
	
* 8/11/19:
	* Corretto combattimento sulla Z tra table e i bottoni
	* ritocco di alcune texture
	
* 9/11/19:
	* correzione bug posizione meteora alla rotazione della mappa
	* correzione teletrasporto Camminatore Errante in caso di caduta in acqua
	
* 10/11/19:
	* correzione bug posizione meteora al spostamento e rotazione durante la sua animazione
	* correzione limite scalino altezza Camminatore Errante
 	
#### Programmi usati

* immagini e texture Paint.net ver: 4.205  
* shader test ShaderToy	  
* editor di testo Notepad++ ver: 7.7.1  
* server Web Apache ver: 2.4  
* Modellazione 3D Blender ver: 2.8


#### shader vari

* materialBussola 	: fragmentBussola, 		vertex			
* materialButton 	: fragmentButton,		vertex
* materialSnow  	: fragmentSnow, 		vertex
* materialSand		: fragmentSand, 		vertex
* materialBadRock	: fragmentBadRock, 		vertex
* materialWater		: fragmentWater, 		vertexWater
* materialGrass		: fragmentGrass, 		vertexGrass
* materialExplosion	: fragmentExplosion, 	vertexExplosion
* materialMeteora	: fragmentMeteora,	 	vertexMeteora