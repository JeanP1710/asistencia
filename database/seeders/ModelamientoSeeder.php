<?php

namespace Database\Seeders;

use App\Models\Alternativa;
use App\Models\Examen;
use App\Models\Pregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $idmod= Examen::where('titulo', 'TALLER DE MODELAMIENTO DE SOFTWARE-    prueba')->value('id');



        $preguntas=[
            [
                'text' => '¿Cuál es el propósito principal del modelado de software en el desarrollo de sistemas?',
                'examen_id' => $idmod,
                'codrespuesta' => 'c',
                'respuesta' => 'Permitir a los desarrolladores visualizar, diseñar y comunicar la arquitectura y el funcionamiento de un sistema antes de comenzar su implementación.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Aumentar la velocidad de codificación de los desarrolladores.'],
                    ['cod' => 'b', 'text' => 'Reducir los costos de hardware en el desarrollo de sistemas.'],
                    ['cod' => 'c', 'text' => 'Permitir a los desarrolladores visualizar, diseñar y comunicar la arquitectura y el funcionamiento de un sistema antes de comenzar su implementación.'],
                    ['cod' => 'd', 'text' => 'Mejorar la estética de las interfaces de usuario.'],
                ]
            ],
            [
                'text' => '¿Qué beneficios ofrece el modelado de software en el desarrollo de sistemas robustos y escalables?',
                'examen_id' => $idmod,
                'codrespuesta' => 'd',
                'respuesta' => 'Facilita la comprensión y comunicación de la arquitectura del sistema, permite identificar problemas de diseño temprano y asegura que todos los desarrolladores tengan una visión clara del funcionamiento del sistema.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Proporciona herramientas para la depuración automática de código.'],
                    ['cod' => 'b', 'text' => 'Optimiza el rendimiento del hardware sin necesidad de cambios en el software.'],
                    ['cod' => 'c', 'text' => 'Garantiza la compatibilidad con todos los sistemas operativos disponibles.'],
                    ['cod' => 'd', 'text' => 'Facilita la comprensión y comunicación de la arquitectura del sistema, permite identificar problemas de diseño temprano y asegura que todos los desarrolladores tengan una visión clara del funcionamiento del sistema.'],
                ]
            ],
            [
                'text' => '¿Cuál es el propósito principal de la abstracción en el desarrollo de software?',
                'examen_id' => $idmod,
                'codrespuesta' => 'b',
                'respuesta' => 'Enfocarse en los aspectos esenciales de un sistema de software y ocultar los detalles de implementación innecesarios.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Aumentar la velocidad de ejecución del software.'],
                    ['cod' => 'b', 'text' => 'Enfocarse en los aspectos esenciales de un sistema de software y ocultar los detalles de implementación innecesarios.'],
                    ['cod' => 'c', 'text' => 'Optimizar el uso de memoria y recursos de hardware.'],
                    ['cod' => 'd', 'text' => 'Garantizar la compatibilidad con múltiples plataformas de hardware.'],
                ]
            ],
            [
                'text' => '¿Cómo facilita la abstracción el diseño, la comunicación y el mantenimiento del software?',
                'examen_id' => $idmod,
                'codrespuesta' => 'c',
                'respuesta' => 'Simplificando la representación y comprensión de un sistema, permitiendo a los desarrolladores enfocarse en sus propiedades y comportamientos esenciales.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Aumentando la cantidad de código necesario para implementar un sistema.'],
                    ['cod' => 'b', 'text' => 'Reduciendo la necesidad de pruebas de software extensivas.'],
                    ['cod' => 'c', 'text' => 'Simplificando la representación y comprensión de un sistema, permitiendo a los desarrolladores enfocarse en sus propiedades y comportamientos esenciales.'],
                    ['cod' => 'd', 'text' => 'Eliminando la necesidad de documentar el código fuente.'],
                ]
            ],
            [
                'text' => '¿Qué es la descomposición en el contexto del desarrollo de software?',
                'examen_id' => $idmod,
                'codrespuesta' => 'a',
                'respuesta' => 'El proceso de dividir un sistema complejo en componentes más pequeños y manejables.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'El proceso de dividir un sistema complejo en componentes más pequeños y manejables.'],
                    ['cod' => 'b', 'text' => 'La técnica de optimizar el rendimiento del software.'],
                    ['cod' => 'c', 'text' => 'El proceso de eliminar redundancias en el código.'],
                    ['cod' => 'd', 'text' => 'La práctica de documentar el código de software extensivamente.'],
                ]
            ],
            [
                'text' => '¿Cómo ayuda la descomposición en el diseño y mantenimiento de un sistema de software?',
                'examen_id' => $idmod,
                'codrespuesta' => 'd',
                'respuesta' => 'Permite dividir un problema grande y complejo en partes más pequeñas y manejables, facilitando el desarrollo, prueba y mantenimiento de cada componente por separado.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Incrementa la velocidad de desarrollo del software.'],
                    ['cod' => 'b', 'text' => 'Reduce la necesidad de pruebas de software.'],
                    ['cod' => 'c', 'text' => 'Elimina la necesidad de documentar el software.'],
                    ['cod' => 'd', 'text' => 'Permite dividir un problema grande y complejo en partes más pequeñas y manejables, facilitando el desarrollo, prueba y mantenimiento de cada componente por separado.'],
                ]
            ],
            [
                'text' => '¿Qué principio se basa en la descomposición en el desarrollo de software?',
                'examen_id' => $idmod,
                'codrespuesta' => 'c',
                'respuesta' => 'El principio de modularidad, donde cada componente realiza una función específica y puede ser desarrollado, probado y mantenido de manera independiente.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'El principio de abstracción.'],
                    ['cod' => 'b', 'text' => 'El principio de encapsulación.'],
                    ['cod' => 'c', 'text' => 'El principio de modularidad, donde cada componente realiza una función específica y puede ser desarrollado, probado y mantenido de manera independiente.'],
                    ['cod' => 'd', 'text' => 'El principio de herencia.'],
                ]
            ],
            [
                'text' => '¿Qué es un caso de uso en el contexto del desarrollo de software?',
                'examen_id' => $idmod,
                'codrespuesta' => 'b',
                'respuesta' => 'Una descripción detallada de cómo un usuario interactúa con un sistema para lograr un objetivo específico.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Un diagrama que muestra la arquitectura física del sistema.'],
                    ['cod' => 'b', 'text' => 'Una descripción detallada de cómo un usuario interactúa con un sistema para lograr un objetivo específico.'],
                    ['cod' => 'c', 'text' => 'Un plan de pruebas para verificar la funcionalidad del software.'],
                    ['cod' => 'd', 'text' => 'Una técnica de modelado de datos.'],
                ]
            ],
            [
                'text' => '¿Cuál es el propósito principal de los casos de uso en el desarrollo de software?',
                'examen_id' => $idmod,
                'codrespuesta' => 'a',
                'respuesta' => 'Definir y comunicar los requisitos funcionales del sistema desde la perspectiva del usuario.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Definir y comunicar los requisitos funcionales del sistema desde la perspectiva del usuario.'],
                    ['cod' => 'b', 'text' => 'Documentar la arquitectura interna del sistema.'],
                    ['cod' => 'c', 'text' => 'Describir los errores potenciales del sistema.'],
                    ['cod' => 'd', 'text' => 'Especificar el diseño visual de la interfaz de usuario.'],
                ]
            ],
            [
                'text' => '¿Cuál es la principal diferencia entre un diagrama de secuencia y un diagrama de actividades en UML?',
                'examen_id' => $idmod,
                'codrespuesta' => 'c',
                'respuesta' => 'Un diagrama de secuencia muestra la secuencia de interacciones entre objetos a lo largo del tiempo, mientras que un diagrama de actividades describe el flujo de actividades o acciones en un proceso o procedimiento.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Un diagrama de secuencia se utiliza para modelar la estructura estática de un sistema, mientras que un diagrama de actividades se utiliza para modelar la estructura dinámica.'],
                    ['cod' => 'b', 'text' => 'Un diagrama de secuencia se utiliza para modelar la estructura de clases y sus relaciones, mientras que un diagrama de actividades se utiliza para modelar el comportamiento de los objetos en tiempo de ejecución.'],
                    ['cod' => 'c', 'text' => 'Un diagrama de secuencia muestra la secuencia de interacciones entre objetos a lo largo del tiempo, mientras que un diagrama de actividades describe el flujo de actividades o acciones en un proceso o procedimiento.'],
                    ['cod' => 'd', 'text' => 'Un diagrama de secuencia se utiliza para modelar las relaciones de dependencia entre objetos, mientras que un diagrama de actividades se utiliza para modelar las relaciones de herencia entre clases.'],
                ]
            ],
            [
                'text' => '¿Qué tipo de situaciones se modelan mejor con un diagrama de secuencia en UML?',
                'examen_id' => $idmod,
                'codrespuesta' => 'b',
                'respuesta' => 'Interacciones detalladas entre objetos a lo largo del tiempo, especialmente en escenarios de interacción complejos.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Procesos o procedimientos que involucran múltiples actividades y decisiones.'],
                    ['cod' => 'b', 'text' => 'Interacciones detalladas entre objetos a lo largo del tiempo, especialmente en escenarios de interacción complejos.'],
                    ['cod' => 'c', 'text' => 'Flujos de control en un sistema de software, incluyendo bucles y ramificaciones.'],
                    ['cod' => 'd', 'text' => 'Estructuras de datos y relaciones estáticas entre clases y objetos.'],
                ]
            ],
            [
                'text' => '¿Cuál es el principal objetivo de un diagrama de actividades en UML?',
                'examen_id' => $idmod,
                'codrespuesta' => 'a',
                'respuesta' => 'Modelar el flujo de actividades o acciones en un proceso o procedimiento, mostrando el orden de ejecución y las decisiones tomadas.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Modelar el flujo de actividades o acciones en un proceso o procedimiento, mostrando el orden de ejecución y las decisiones tomadas.'],
                    ['cod' => 'b', 'text' => 'Representar las interacciones entre objetos a lo largo del tiempo, incluyendo los mensajes intercambiados entre ellos.'],
                    ['cod' => 'c', 'text' => 'Describir la estructura estática de un sistema, incluyendo clases, objetos y sus relaciones.'],
                    ['cod' => 'd', 'text' => 'Definir la arquitectura de un sistema de software, incluyendo sus componentes y sus interacciones.'],
                ]
            ],
            [
                'text' => '¿Cuál es la principal diferencia entre un diagrama de clases y un diagrama de paquetes en UML?',
                'examen_id' => $idmod,
                'codrespuesta' => 'b',
                'respuesta' => 'La diferencia principal radica en el nivel de abstracción y granularidad; mientras que un diagrama de clases se centra en las relaciones y estructura interna de las clases, un diagrama de paquetes agrupa clases relacionadas en módulos de más alto nivel.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'La diferencia principal radica en la representación gráfica; un diagrama de clases muestra clases y sus relaciones mediante cajas y líneas, mientras que un diagrama de paquetes utiliza paquetes y sus dependencias mediante flechas direccionales.'],
                    ['cod' => 'b', 'text' => 'La diferencia principal radica en el nivel de abstracción y granularidad; mientras que un diagrama de clases se centra en las relaciones y estructura interna de las clases, un diagrama de paquetes agrupa clases relacionadas en módulos de más alto nivel.'],
                    ['cod' => 'c', 'text' => 'La diferencia principal radica en su uso; un diagrama de clases se utiliza principalmente en la fase de diseño detallado, mientras que un diagrama de paquetes se utiliza en la fase de arquitectura de alto nivel para definir la estructura modular del sistema.'],
                    ['cod' => 'd', 'text' => 'La diferencia principal radica en su complejidad; un diagrama de clases es más detallado y específico, mostrando las propiedades y métodos de cada clase, mientras que un diagrama de paquetes es más abstracto y general, mostrando relaciones entre módulos de alto nivel.'],
                ]
            ],
            [
                'text' => 'En un contexto de desarrollo de software a gran escala, ¿cuál sería la principal ventaja de utilizar un diagrama de paquetes sobre un diagrama de clases?',
                'examen_id' => $idmod,
                'codrespuesta' => 'c',
                'respuesta' => 'La principal ventaja radicaría en la capacidad de gestionar la complejidad del sistema al proporcionar una vista de alto nivel de la estructura modular, lo que facilita la identificación de dependencias entre componentes y la gestión del acoplamiento y la cohesión.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'La principal ventaja radicaría en la precisión y detalle del diagrama, lo que permite una comprensión exhaustiva de la estructura interna de las clases y sus relaciones.'],
                    ['cod' => 'b', 'text' => 'La principal ventaja radicaría en la flexibilidad del diagrama, permitiendo la fácil adición o modificación de clases individuales sin afectar la estructura global del sistema.'],
                    ['cod' => 'c', 'text' => 'La principal ventaja radicaría en la capacidad de gestionar la complejidad del sistema al proporcionar una vista de alto nivel de la estructura modular, lo que facilita la identificación de dependencias entre componentes y la gestión del acoplamiento y la cohesión.'],
                    ['cod' => 'd', 'text' => 'La principal ventaja radicaría en la comunicación efectiva entre equipos de desarrollo, permitiendo una comprensión común de la arquitectura del sistema y sus componentes.'],
                ]
            ],
            [
                'text' => '¿Cuál es la principal diferencia entre un diagrama estructural y un diagrama funcional en el contexto de UML?',
                'examen_id' => $idmod,
                'codrespuesta' => 'b',
                'respuesta' => 'La principal diferencia radica en el enfoque del diagrama; mientras que un diagrama estructural se centra en la organización y relaciones estáticas entre los elementos del sistema, un diagrama funcional describe la secuencia de eventos y comportamientos dinámicos del sistema.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'La principal diferencia radica en la representación gráfica; un diagrama estructural utiliza cajas y líneas para mostrar la estructura estática del sistema, mientras que un diagrama funcional utiliza diagramas de flujo para representar la lógica y el comportamiento del sistema.'],
                    ['cod' => 'b', 'text' => 'La principal diferencia radica en el enfoque del diagrama; mientras que un diagrama estructural se centra en la organización y relaciones estáticas entre los elementos del sistema, un diagrama funcional describe la secuencia de eventos y comportamientos dinámicos del sistema.'],
                    ['cod' => 'c', 'text' => 'La principal diferencia radica en su aplicación; un diagrama estructural se utiliza principalmente en la fase de diseño de alto nivel para definir la arquitectura del sistema, mientras que un diagrama funcional se utiliza en la fase de diseño detallado para especificar el comportamiento de las funciones individuales.'],
                    ['cod' => 'd', 'text' => 'La principal diferencia radica en su complejidad; un diagrama estructural es más detallado y específico, mostrando la estructura interna de los componentes del sistema, mientras que un diagrama funcional es más abstracto y general, describiendo la interacción entre las funciones del sistema.'],
                ]
            ],
            [
                'text' => 'En un proyecto de desarrollo de software, ¿cuál sería la utilidad principal de utilizar un diagrama estructural en comparación con un diagrama funcional?',
                'examen_id' => $idmod,
                'codrespuesta' => 'c',
                'respuesta' => 'La utilidad principal sería proporcionar una visión estática y detallada de la organización del sistema, lo que facilita la comprensión de la arquitectura del sistema y la identificación de componentes clave y sus relaciones.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'La utilidad principal sería proporcionar una representación gráfica de las secuencias de eventos y comportamientos del sistema, lo que facilita la comprensión de cómo interactúan las funciones del sistema en diferentes escenarios.'],
                    ['cod' => 'b', 'text' => 'La utilidad principal sería permitir una comunicación efectiva entre equipos de desarrollo, proporcionando una comprensión común de la lógica y el comportamiento del sistema.'],
                    ['cod' => 'c', 'text' => 'La utilidad principal sería proporcionar una visión estática y detallada de la organización del sistema, lo que facilita la comprensión de la arquitectura del sistema y la identificación de componentes clave y sus relaciones.'],
                    ['cod' => 'd', 'text' => 'La utilidad principal sería facilitar la documentación del sistema y la especificación de requisitos funcionales, lo que permite una comprensión clara de las funcionalidades que debe cumplir el sistema.'],
                ]
            ],
            [
                'text' => 'En un diagrama de secuencia UML, ¿qué representa una flecha vertical entre dos objetos?',
                'examen_id' => $idmod,
                'codrespuesta' => 'b',
                'respuesta' => 'Representa un mensaje enviado desde el objeto de origen al objeto de destino, indicando una interacción entre ellos durante la ejecución del sistema.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Representa una relación de herencia entre las clases asociadas con los objetos.'],
                    ['cod' => 'b', 'text' => 'Representa un mensaje enviado desde el objeto de origen al objeto de destino, indicando una interacción entre ellos durante la ejecución del sistema.'],
                    ['cod' => 'c', 'text' => 'Representa la creación de un nuevo objeto durante la ejecución del sistema.'],
                    ['cod' => 'd', 'text' => 'Representa una asociación entre los objetos, indicando que un objeto es parte de otro.'],
                ]
            ],
            [
                'text' => 'En un diagrama de casos de uso UML, ¿qué representa un óvalo?',
                'examen_id' => $idmod,
                'codrespuesta' => 'c',
                'respuesta' => 'Representa un actor, que puede ser un usuario humano, un sistema externo o cualquier entidad que interactúe con el sistema en estudio.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Representa un caso de uso, que describe una función o una acción realizada por el sistema en respuesta a una solicitud del actor.'],
                    ['cod' => 'b', 'text' => 'Representa una asociación entre dos casos de uso, indicando que uno depende del otro para su ejecución.'],
                    ['cod' => 'c', 'text' => 'Representa un actor, que puede ser un usuario humano, un sistema externo o cualquier entidad que interactúe con el sistema en estudio.'],
                    ['cod' => 'd', 'text' => 'Representa una relación de inclusión entre dos casos de uso, indicando que uno contiene la funcionalidad del otro.'],
                ]
            ],
            [
                'text' => 'En un diagrama de secuencia UML, ¿qué representa una línea de vida (lifeline)?',
                'examen_id' => $idmod,
                'codrespuesta' => 'a',
                'respuesta' => 'Representa la existencia temporal de un objeto durante la ejecución del sistema, mostrando el período de tiempo en el que el objeto está activo y participa en la interacción.',
                'alternativas' => [
                    ['cod' => 'a', 'text' => 'Representa la existencia temporal de un objeto durante la ejecución del sistema, mostrando el período de tiempo en el que el objeto está activo y participa en la interacción.'],
                    ['cod' => 'b', 'text' => 'Representa la ejecución de un método específico de un objeto, mostrando el flujo de control dentro del objeto durante la interacción.'],
                    ['cod' => 'c', 'text' => 'Representa una restricción o condición que debe cumplirse para que se produzca una interacción entre dos objetos.'],
                    ['cod' => 'd', 'text' => 'Representa una conexión directa entre dos objetos, indicando que hay una relación de dependencia entre ellos.'],
                ]
            ]                      
        ];
        foreach ($preguntas as $menuData) {
            $pregunta = Pregunta::firstOrCreate([
                'text' => $menuData['text'], 
                'examen_id' => $menuData['examen_id'], 
                'codrespuesta' => $menuData['codrespuesta'], 
                'respuesta' => $menuData['respuesta'],
            ]);
            foreach($menuData['alternativas'] as $alternativa){
                $alternativa = Alternativa::firstorCreate([
                    'text' => $alternativa['text'], 
                    'cod' => $alternativa['cod']
                ]);
                $pregunta->alternativas()->attach($alternativa->id);
                // $pregunta->alternativas()->sync([
                //     $alternativa->id
                // ]);
            }
        }
    }
}
