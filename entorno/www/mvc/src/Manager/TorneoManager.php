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
        if ($torneoGeneroCategoria->isCerrado()) {
            return;
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
        $torneoGeneroCategoria = $this->torneoGeneroCategoriaRepository->find($id);
        if ($torneoGeneroCategoria->isCreado()) {
            return;
        }
        $zonas = $this->zonaRepository->findBy(['torneoGeneroCategoria' => $id]);
        foreach ($zonas as $zona) {
            $equipos = $this->zonaEquipoRepository->findBy(['zona' => $zona->getId()]);
            for ($i=0; $i < count($equipos); $i++) {
                for ($j=$i+1; $j < count($equipos); $j++) { 
                    $partido = new Partido();
                    $partido->setZona($zona);
                    $partido->setEquipoLocal($equipos[$i]->getEquipo());
                    $partido->setEquipoVisitante($equipos[$j]->getEquipo());
                    $partido->setCreatedAt();
                    $partido->setUpdatedAt();
                    $this->partidoRepository->guardarPartido($partido);
                    
                }
            }
        }
        $this->torneoGeneroCategoriaRepository->actualizarTGC($torneoGeneroCategoria->setCreado(true));
        
    }
}