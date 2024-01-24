<?php

namespace App\Manager;

use App\Entity\Partido;
use App\Entity\Zona;
use App\Entity\ZonaEquipo;
use App\Repository\EquipoRepository;
use App\Repository\PartidoRepository;
use App\Repository\TorneoGeneroCategoriaRepository;
use App\Repository\ZonaEquipoRepository;
use App\Repository\ZonaRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class TorneoManager{
    public function __construct(
        private EquipoRepository $equipoRepository,
        private ZonaRepository $zonaRepository,
        private ZonaEquipoRepository $zonaEquipoRepository,
        private TorneoGeneroCategoriaRepository $torneoGeneroCategoriaRepository,
        private PartidoRepository $partidoRepository

    ) {
        
    }
    
    public function armadoZona(): array
    {   
        $equipos = $this->equipoRepository->findAll();
        $categorias = [];
        foreach ($equipos as $equipo) {
            if ($equipo->getZonaEquipo())
            {
                $categorias[$equipo->getZonaEquipo()->getZona()->getTorneoGeneroCategoria()->getGenero()->getNombre().''.$equipo->getZonaEquipo()->getZona()->getTorneoGeneroCategoria()->getCategoria()->getNombre()][$equipo->getZonaEquipo()->getZona()->getId()][] = $equipo;
            }
        }
        return $categorias;
    }

    public function armadoFixture(int $idTorneoGeneroCategoria, int $cantidadZonas, $array ): void
    {   
        $torneoGeneroCategoria = null;
        $equipos = $this->equipoRepository->findAll();
        foreach ($equipos as $equipo) {
            if ($equipo->getTorneoGeneroCategoria()->getId() === $idTorneoGeneroCategoria )
            {   
                $torneoGeneroCategoria = $equipo->getTorneoGeneroCategoria();
                $equiposZona[] = $equipo;
            }
        }
        $id = 0;
        for ($i=0; $i < $cantidadZonas; $i++) { 
            $zona = new Zona();
            $zona->setTorneoGeneroCategoria($torneoGeneroCategoria);
            $this->zonaRepository->guardarZona($zona);
            for ($j=0; $j < $array[$i]; $j++) { 
                $zonaEquipo = new ZonaEquipo();
                $zonaEquipo->setZona($zona);
                $zonaEquipo->setEquipo($equiposZona[$id++]);
                $this->zonaEquipoRepository->guardarZonaEquipo($zonaEquipo);
            }
        }
        $this->torneoGeneroCategoriaRepository->actualizarTGC($torneoGeneroCategoria->setCerrado(true));
    }

    public function armarPartidos(int $id): void
    {   
        $zonas = $this->zonaRepository->findAll();
        $equipos = $this->equipoRepository->findAll();
        $zonaOk = null;
        foreach ($zonas as $zona) {
            if ($zona->getTorneoGeneroCategoria()->getId() === $id)
            {
                $zonaOk = $zona;
            }
        }

        var_dump($zonaOk);die();

        foreach ($equipos as $equipo) {
            if ($equipo->getZonaEquipo()->getZona()->getId() === $zonaOk->getId())
            {
                $partido = new Partido();
                $partido->setZona($zonaOk);
                $this->partidoRepository->guardarPartido($partido);
            }
        }
        die();
    }
}