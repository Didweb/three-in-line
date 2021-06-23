3 in Line y más ;P
==================

Kata especifica para desarrollar estructura Hexagonal.

Con un juego de N en Raya. Tablero dinámico.

---

**Proyecto dividido en**:

- Application
- Domian
- Infrastructure

---

**Separación entre capas**:

- Repositorio mediante Inversión de dependencia.
- Modelos en infraestructura separados mediante “CommandHandler”(Application) Sin llegar usar CQRS

---

### IA

El juego esta pensado para ser jugado por un jugador “Humano” y la IA.

### Criterio de IA:

#### Capa de Bloqueo:
La IA actualmente se orienta en **bloquear** al jugador “Humano”. tapando las mejores opciones del "Humano" para generar las fichas en linea.

#### Capa de Triunfo: EN PROCESO
Una vez la IA nos haya encontrado las mejores opciones para bloquearnos. 
Ha de generar una búsqueda de la mejor celda
en caso de que pueda ganar la IA, para ponderarla de tal forma que gane la partida.




### El criterio de IA "Capa de Bloqueo" o llamado en el contexto “Watcher”.

Una vez que el “Humano” realiza la tirada, la IA dará un valor a cada celda, y tirara su turno en la casilla con mayor  valor. En caso de empate se hace un random entre las de mayor puntuación.

Los criterios para valorar los puntos de cada celda. Hace un barrido de las celdas vecinas por Filas, columnas y las 2 diagonales (áreas).

**Criterios**:
- Si una área tiene una ficha Humana = Asigna puntos.
- Si ya existe una ficha de la IA = resta punto.
- Si falta una ficha “Humana” para completar la raya = suma puntas prioridad máxima para bloque al contrario.


**Patrones**:

- Patrón Hexagonal.
- Para el “Watcher” sistema de IA, se ha creado un factoria de “Watchers” para cada tipo Priomera diagonal, Segunda diagonal, columnas y filas. Lso Watcher extienden de una clase abstracta.
- CommanHandler, sin llegara usar CQRS, separación de capas con Handler.

---

### Persistencia de datos

Se almacenan los datos del tablero en un archivo en formato Yaml. La persistencia esta desacoplada mediante inversión de dependencias para que pueda ser substituida por ejemplo por un MySQL.

---

### Testing

Test unitarios:
- Creación de tablero "Board".
- Movimineto "Humano".
- IA Robot en un caso controlado para que mueva ficha en la mejor opción.

