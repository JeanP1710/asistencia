<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Registro;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $personas = [
            [
                'dni'           => '',
                'ape_paterno'   => 'EVARISTO',
                'ape_materno'   => 'COZ',
                'nombres'       => 'RUTH YERY',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'EVARISTO',
                'ape_materno'   => 'MALPARTIDA',
                'nombres'       => 'YOISI YARITZA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'MINAYA',
                'ape_materno'   => 'NOREÑA',
                'nombres'       => 'MARIELA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'MONTESINOS',
                'ape_materno'   => 'CALDERON',
                'nombres'       => 'BRANDON ALBERTO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'RAMIREZ',
                'ape_materno'   => 'JIMENEZ',
                'nombres'       => 'CARLOS HIPOLITO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'LEIVA',
                'ape_materno'   => 'CAPCHA',
                'nombres'       => 'ELVIS',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CRISTOBAL',
                'ape_materno'   => 'SANTIAGO',
                'nombres'       => 'KELY ESTEFANY',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'BRAVO',
                'ape_materno'   => 'ISIDRO',
                'nombres'       => 'ALEXANDRA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'SALAS',
                'ape_materno'   => 'HUAMAN',
                'nombres'       => 'NOEMI RAQUEL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'MALPARTIDA',
                'ape_materno'   => 'LUQUILLAS',
                'nombres'       => 'JUAN JOSUE',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'DOMINGUEZ',
                'ape_materno'   => 'SANTIAGO',
                'nombres'       => 'LIMBER ADEL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'TEMPLADERA',
                'ape_materno'   => 'AMARO',
                'nombres'       => 'JELY YUDITH',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'TADEO',
                'ape_materno'   => 'FLORES',
                'nombres'       => 'IMER UEL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ECHEVARRIA',
                'ape_materno'   => 'MARTINEZ',
                'nombres'       => 'EDITH YOSSALINDA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ROSALES',
                'ape_materno'   => 'CANTARO',
                'nombres'       => 'LIANELLY FABIOLA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'VILLANUEVA',
                'ape_materno'   => 'CARBAJAL',
                'nombres'       => 'FRANCO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'TARAZONA',
                'ape_materno'   => 'REYES',
                'nombres'       => 'RODRIGO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'JORGE',
                'ape_materno'   => 'BENANCIO',
                'nombres'       => 'LINDER JOEL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'SULLCA',
                'ape_materno'   => 'TORRES',
                'nombres'       => 'INGRID KRISTELL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ESPINOZA',
                'ape_materno'   => 'DAVILA',
                'nombres'       => 'ENDIRA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'AMANCIO',
                'ape_materno'   => 'MIRAVAL',
                'nombres'       => 'HILDER ALEJANDRO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PEREZ',
                'ape_materno'   => 'CARRION',
                'nombres'       => 'GEYLI BARLYNE',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'VENTURA',
                'ape_materno'   => 'GOMEZ',
                'nombres'       => 'JENRRY LINDER',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'HERRERA',
                'ape_materno'   => 'ASTO',
                'nombres'       => 'DYLNER YELIX',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'LOPEZ',
                'ape_materno'   => 'SIFUENTES',
                'nombres'       => 'JESSUP RONALDO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'FABIAN',
                'ape_materno'   => 'LUCAS',
                'nombres'       => 'FRANKLIN ROSSEL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ATAVILLOS',
                'ape_materno'   => 'FUGENIO',
                'nombres'       => 'WILSON JUNIOR',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'YALICO',
                'ape_materno'   => 'NIEVES',
                'nombres'       => 'YEFRAN',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'SALIS',
                'ape_materno'   => 'JUSTO',
                'nombres'       => 'GIELSEN',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'SIFUENTES',
                'ape_materno'   => 'LUNA',
                'nombres'       => 'YADIRA CELIA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'HERREA',
                'ape_materno'   => 'ESQUIVEL',
                'nombres'       => 'JIMENA FLORENCIA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'MALPARTIDA',
                'ape_materno'   => 'FALERA',
                'nombres'       => 'JAQUELINE MILAGROS',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'VILLA',
                'ape_materno'   => 'VARGAS',
                'nombres'       => 'BRIYITH',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CRUZ',
                'ape_materno'   => 'DOLORES',
                'nombres'       => 'YERLY',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'APOLIN',
                'ape_materno'   => 'VIGILIO',
                'nombres'       => 'ENVER MOISES ANTONY',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'EVARISTO',
                'ape_materno'   => 'MASGO',
                'nombres'       => 'LUZ THALIA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'EVARISTO',
                'ape_materno'   => 'PEREZ',
                'nombres'       => 'CENIA MARLENI',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'VENTURA',
                'ape_materno'   => 'GUZMAN',
                'nombres'       => 'LALY EVELYN',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'MARIACA',
                'ape_materno'   => 'AYCAYA',
                'nombres'       => 'ALVARO FERNANDO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ARAUJO',
                'ape_materno'   => 'MORALES',
                'nombres'       => 'YALU YOLINDA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'OSCAR',
                'ape_materno'   => 'AVILIO',
                'nombres'       => 'ADRIANO CAYCO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CHAVEZ',
                'ape_materno'   => 'RAMOS',
                'nombres'       => 'ESTEFANY',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'EVARISTO',
                'ape_materno'   => 'CANTARO',
                'nombres'       => 'JOSE ELI',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'AYALA',
                'ape_materno'   => 'LORENZO',
                'nombres'       => 'FLOR ELMA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'JAIMES',
                'ape_materno'   => 'RIMAS',
                'nombres'       => 'RONALDO CHIVALER',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'AQUINO',
                'ape_materno'   => 'MARTEL',
                'nombres'       => 'FRANK DARWIN',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CRISTINO',
                'ape_materno'   => 'ALANIA',
                'nombres'       => 'ROSALINA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'LOPEZ',
                'ape_materno'   => 'SALIS',
                'nombres'       => 'MARCO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'LLANTO',
                'ape_materno'   => 'ALVARADO',
                'nombres'       => 'LUZ ANALI',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CARHUAMACA',
                'ape_materno'   => 'MORALES',
                'nombres'       => 'ALEXANDER BRYAN',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'BUSTINZA',
                'ape_materno'   => 'SANTAMARIA',
                'nombres'       => 'LUIS ALVARADO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'DIONICIO',
                'ape_materno'   => 'PRADO',
                'nombres'       => 'SEBASTIAN ALEX',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CARBAJAL',
                'ape_materno'   => 'PICOY',
                'nombres'       => 'LUZ JANET',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'MUNGUIA',
                'ape_materno'   => 'AQUINO',
                'nombres'       => 'MAYRA MEDALID',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'HERRERA',
                'ape_materno'   => 'MORY',
                'nombres'       => 'ELSA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ROJAS',
                'ape_materno'   => 'ESPINOZA',
                'nombres'       => 'MARCO ANTONIO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PONCE',
                'ape_materno'   => 'FALCON',
                'nombres'       => 'CALORINA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'INOCENCIO',
                'ape_materno'   => 'NATIVIDAD',
                'nombres'       => 'GIMENA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'NAZARIO',
                'ape_materno'   => 'CORNE',
                'nombres'       => 'YANETH BERTHILA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PONCIANO',
                'ape_materno'   => 'ROMERO',
                'nombres'       => 'NOEMI',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CHAVEZ',
                'ape_materno'   => 'RAMOS',
                'nombres'       => 'SILVESTRINA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'LUCAS',
                'ape_materno'   => 'SOTO',
                'nombres'       => 'ISRAEL LENIN',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ROJAS',
                'ape_materno'   => 'DURAN',
                'nombres'       => 'EDISON ALEXIS',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CASIO',
                'ape_materno'   => 'TAFUR',
                'nombres'       => 'LINA ZORAIDA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PONCE',
                'ape_materno'   => 'DIEGO',
                'nombres'       => 'SHARON YOISI',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'HIPOLO',
                'ape_materno'   => 'PADILLA',
                'nombres'       => 'DENIN ISAAC',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'BOZA',
                'ape_materno'   => 'AYALA',
                'nombres'       => 'LILA BEATRIZ',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CERVANTES',
                'ape_materno'   => 'SOTO',
                'nombres'       => 'JUANA LUZ ELENA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'EUSTAQUIO',
                'ape_materno'   => 'SOLORZANO',
                'nombres'       => 'FLOR MELITA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'HAUYNATE',
                'ape_materno'   => 'RAMIREZ',
                'nombres'       => 'OTILIANO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'DEPAZ',
                'ape_materno'   => 'JUSTO',
                'nombres'       => 'LUZ NATALY',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'RIVERA',
                'ape_materno'   => 'RAMIREZ',
                'nombres'       => 'MOISES GABRIEL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'GAMARRA',
                'ape_materno'   => 'ZAMBRANO',
                'nombres'       => 'YOMER',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'RUPAY',
                'ape_materno'   => 'VALDIVIA',
                'nombres'       => 'SAIDA DANIRA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'BARRUETA',
                'ape_materno'   => 'FABIAN',
                'nombres'       => 'NOE',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ALVARADO',
                'ape_materno'   => 'ROJAS',
                'nombres'       => 'FATIMA DEL PILAR',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ESPINOZA',
                'ape_materno'   => 'DE LA CRUZ',
                'nombres'       => 'JUAN ALBERTO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ARTEAGA',
                'ape_materno'   => 'ARIAS',
                'nombres'       => 'OMAR',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PLACIDO',
                'ape_materno'   => 'BAUTISTA',
                'nombres'       => 'NICOLK',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CABELLO',
                'ape_materno'   => 'ROQUE',
                'nombres'       => 'SHOMARA MILAGROS',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'GARCIA',
                'ape_materno'   => 'JAPA',
                'nombres'       => 'LUZ AMERICA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ASTO',
                'ape_materno'   => 'ESTELA',
                'nombres'       => 'LUZ CLARITA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'HILARIO',
                'ape_materno'   => 'ALANIA',
                'nombres'       => 'LUZ MERLY',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PARDO',
                'ape_materno'   => 'CECILIO',
                'nombres'       => 'ADOLFO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PAREDES',
                'ape_materno'   => 'FERNANDEZ',
                'nombres'       => 'JUNIOR',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ANDRES',
                'ape_materno'   => 'MALLQUI',
                'nombres'       => 'JHONY NARDO',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CORDOVA',
                'ape_materno'   => 'BRICEÑO',
                'nombres'       => 'BRIYIT',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ESPINOZA',
                'ape_materno'   => 'CALDERON',
                'nombres'       => 'DEISSY DALITH',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CELIS',
                'ape_materno'   => 'MAYLLE',
                'nombres'       => 'SHIRLY JANINA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'CARDENAS',
                'ape_materno'   => 'SANDOVAL',
                'nombres'       => 'ROXANA CINTHIA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'JUSTO',
                'ape_materno'   => 'BORJA',
                'nombres'       => 'MOISES',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'LEON',
                'ape_materno'   => 'HUARANGA',
                'nombres'       => 'ABIGAIL',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'RUIZ',
                'ape_materno'   => 'ROCANO',
                'nombres'       => 'JAKELINE KAHERINE',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'PACHECO',
                'ape_materno'   => 'PEREZ',
                'nombres'       => 'HEYEN YAJAYRA',
            ],
            [
                'dni'           => '',
                'ape_paterno'   => 'ESPINOZA',
                'ape_materno'   => 'SANTILLAN',
                'nombres'       => 'LUZ ZEINAIDA',
            ],
        ];
        $i=1;
        foreach($personas as $row){
            $persona = Persona::firstorCreate($row);
            Registro::firstorCreate([
                'fecha'     => '2024-04-06',
                'codigo'    => '00052024-'.$i,
                'persona_id'=> $persona->id,
                'curso_tomado'  => 'CHARLA PROYECTO DE INVESTIGACION CIENTIFICA',
                'lugar'     => '',
                'comentario'=> 'CHARLA PROYECTO DE INVESTIGACION CIENTIFICA SABADO 06 DE ABRIL 2024',
            ]);
            $i++;
        }
        $csvFile = fopen(public_path('certificados.csv'), 'r');

        $firstLine = true;
        $i=95;
        while(($fila  = fgetcsv($csvFile,2000,";")) !== false) {
            if(!$firstLine)
            {
                $registro = explode(",",(string)$fila[0]);
                $codigo =$registro[0];
                $fecha = $registro[1];
                $curso_tomado=$registro[2];
                $ape_paterno = $registro[3];
                $ape_materno = $registro[4];
                $nombres = $registro[5];

                $persona = Persona::firstOrCreate([
                    'dni'           => '',
                    'ape_paterno'   => $ape_paterno,
                    'ape_materno'   => $ape_materno,
                    'nombres'       => $nombres,
                ]);
                Registro::firstorCreate([
                    'fecha'     => '2024-04-13',
                    'codigo'    => '00062024-'.$i,
                    'persona_id'=> $persona->id,
                    'curso_tomado'  => 'EMPRESA MODERNA',
                    'lugar'     => '',
                    'comentario'=> 'CHARLA EMPRESA MODERNA 13 DE ABRIL 2024',
                ]);
            }
            $firstLine = false;
            $i++;
        }
        fclose($csvFile);

        
    }
}
