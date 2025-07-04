<?php

namespace Database\Seeders;

use App\Models\MensajeMotivador;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MensajeMotivadorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mensajes = [
            "Cada paso que das hacia tu educación es un paso hacia un futuro brillante. ¡Sigue adelante, estás en el camino correcto!",
            "No importa cuán difícil sea el camino, cada obstáculo superado te acerca un poco más a tus metas. ¡Tú puedes lograrlo!",
            "Tu determinación y esfuerzo son las llaves que abrirán las puertas del éxito. ¡No te rindas!",
            "Recuerda, cada desafío es una oportunidad para crecer y aprender. ¡Afronta tus estudios con valentía y determinación!",
            "El viaje hacia el conocimiento puede ser largo, pero cada paso que das te acerca más a tus sueños. ¡Sigue adelante con pasión y perseverancia!",
            "El conocimiento es poder. Cuanto más aprendas, más fuerte te volverás. ¡No subestimes el poder de tu educación!",
            "No hay límites para lo que puedes lograr si te comprometes con tu educación. ¡Deja que tu pasión por aprender te guíe hacia el éxito!",
            "Las dificultades son temporales, pero las habilidades que adquieres a través de la educación son para toda la vida. ¡Sigue adelante con determinación y confianza!",
            "Cada día es una oportunidad para aprender algo nuevo y acercarte un poco más a tus metas. ¡Aprovecha al máximo cada momento de tu educación!",
            "El éxito no se logra de la noche a la mañana, requiere dedicación y perseverancia. ¡No te desanimes, cada esfuerzo cuenta!",
            "Tus sueños son la fuerza impulsora que te llevará a alcanzar tus metas. ¡Mantén tus sueños vivos y trabaja duro para hacerlos realidad!",
            "Nunca subestimes el poder de tu voz y tu conocimiento. ¡Tienes el potencial para hacer una diferencia en el mundo, así que nunca dejes de aprender y crecer!",
            "Cada desafío que enfrentas te hace más fuerte y te prepara mejor para el futuro. ¡No temas a los desafíos, abrázalos como oportunidades de crecimiento!",
            "Tu educación es un regalo que te abrirá puertas a oportunidades ilimitadas. ¡Aprovéchalo al máximo y nunca dejes de aprender y crecer!",
            "Enfrenta cada día con una mente abierta y un corazón valiente. ¡El aprendizaje continuo es la clave para alcanzar tus sueños!",
            "No importa cuántas veces te caigas, lo que importa es levantarte una vez más y seguir adelante con determinación. ¡Tú tienes el poder de superar cualquier obstáculo!",
            "El camino hacia el éxito puede estar lleno de altibajos, pero cada desafío te hace más fuerte y más preparado para lo que está por venir. ¡Mantén la cabeza en alto y sigue adelante con confianza!",
            "Tu educación es una inversión en tu futuro. ¡No escatimes en esfuerzo y dedicación, porque cada sacrificio valdrá la pena!",
            "No hay límites para lo que puedes lograr si te comprometes con tu crecimiento personal y académico. ¡Confía en ti mismo y en tus habilidades para alcanzar tus metas!",
            "Recuerda, el verdadero éxito no se mide por los logros externos, sino por la satisfacción de saber que diste lo mejor de ti mismo en cada paso del camino. ¡Sigue adelante con determinación y orgullo en tu viaje educativo!",
            "Cada desafío superado te acerca un paso más a tus metas. ¡Confía en ti mismo y en tu capacidad para triunfar!",
            "Tu determinación y persistencia son más fuertes que cualquier obstáculo que puedas enfrentar. ¡Sigue adelante con valentía!",
            "El éxito no se trata solo de llegar a la cima, sino de disfrutar el viaje hacia allí. ¡Disfruta cada paso de tu trayectoria académica!",
            "Recuerda, incluso los expertos alguna vez fueron principiantes. ¡No temas cometer errores, son oportunidades de aprendizaje!",
            "Cada día es una página en blanco, ¡tú tienes el poder de escribir tu propia historia! Hazla épica.",
            "No dejes que el miedo al fracaso te detenga. En cada error hay una lección que te acerca más al éxito.",
            "Tus sueños son como estrellas en el cielo, siempre brillantes y guías en la oscuridad. ¡Sigue persiguiéndolos con pasión!",
            "La verdadera grandeza radica en tu capacidad para levantarte cada vez que caigas. ¡Eres más fuerte de lo que crees!",
            "La educación es el arma más poderosa que puedes usar para cambiar el mundo. ¡Aprovéchala y deja tu huella!",
            "El éxito es el resultado de un esfuerzo constante y una actitud positiva. ¡Mantén la cabeza en alto y avanza con determinación!",
        ];

        foreach ($mensajes as $mensaje) {
            MensajeMotivador::create([
                'mensaje' => $mensaje
            ]);
        }
    }
}
