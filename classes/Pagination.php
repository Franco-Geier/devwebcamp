<?php

namespace Classes;

class Pagination {
    public $current_page;
    public $registrations_per_page;
    public $total_registrations;
    public $max_visible_pages;

    public function __construct($current_page = 1, $registrations_per_page = 10, $total_registrations = 0, $max_visible_pages = 5) {
        $this->current_page = (int)$current_page;
        $this->registrations_per_page = (int)$registrations_per_page;
        $this->total_registrations = (int)$total_registrations;
        $this->max_visible_pages = (int)$max_visible_pages;
    }

    public function offset() {
        return $this->registrations_per_page * ($this->current_page - 1);
    }

    public function total_pages() {
        return ceil($this->total_registrations / $this->registrations_per_page);
    }

    public function previous_page() {
        $previous = $this->current_page - 1;
        return ($previous > 0) ? $previous : false;
    }

    public function next_page() {
        $next = $this->current_page + 1;
        return ($next <= $this->total_pages() ? $next : false);
    }

    public function previous_link() {
        $html = "";
        if($this->previous_page()){ 
            $html .= "<a class=\"pagination__link pagination__link--text\" href=\"?page={$this->previous_page()}\">&laquo; Anterior</a>"; 
        }
        return $html;
    }

    public function next_link() {
        $html = "";
        if($this->next_page()){ 
            $html .= "<a class=\"pagination__link pagination__link--text\" href=\"?page={$this->next_page()}\">Siguiente &raquo;</a>"; 
        }
        return $html;
    }

    // public function numbers_pages() {
    //     $html = "";
    //     for($i = 1; $i <= $this->total_pages(); $i++) {
    //         if($i === $this->current_page) {
    //             $html .= "<span class=\"pagination__link pagination__link--current\">{$i}</span>";
    //         } else {
    //             $html .= "<a class=\"pagination__link pagination__link--number\" href=\"?page={$i}\">{$i}</a>";
    //         }
    //     }
    //     return $html;
    // }

    /**
     * Genera los números de página con límite máximo
     * Esta función calcula inteligentemente qué rango de páginas mostrar
     * basándose en la página actual y el número máximo de páginas visibles
     */
    public function numbers_pages() {
        $html = "";
        $total_pages = $this->total_pages();
        
        //Si el total de páginas es menor o igual al máximo visible, mostrar todas
        if ($total_pages <= $this->max_visible_pages) {
            $start_page = 1;
            $end_page = $total_pages;
        } else {
            // Calcular el punto medio del rango visible
            $half_visible = floor($this->max_visible_pages / 2);
            
            // Calcular página de inicio tentativa
            $start_page = $this->current_page - $half_visible;
            
            // Ajustar si la página de inicio es menor a 1
            if($start_page < 1) {
                $start_page = 1;
                $end_page = $this->max_visible_pages;
            } 
            // Calcular página final tentativa
            else {
                $end_page = $this->current_page + $half_visible;
                
                // Ajustar si la página final excede el total de páginas
                if($end_page > $total_pages) {
                    $end_page = $total_pages;
                    $start_page = $total_pages - $this->max_visible_pages + 1;
                    
                    // Asegurar que start_page no sea menor a 1
                    if ($start_page < 1) {
                        $start_page = 1;
                    }
                }
            }
        }

        // Mostrar primera página y puntos suspensivos si es necesario
        if($start_page > 1) {
            $html .= "<a class=\"pagination__link pagination__link--number\" href=\"?page=1\">1</a>";
            if ($start_page > 2) {
                $html .= "<span class=\"pagination__link pagination__link--dots\">...</span>";
            }
        }

        // Generar los números de página en el rango calculado
        for($i = $start_page; $i <= $end_page; $i++) {
            if((int)$i === (int)$this->current_page) {
                $html .= "<span class=\"pagination__link pagination__link--current\">{$i}</span>";
            } else {
                $html .= "<a class=\"pagination__link pagination__link--number\" href=\"?page={$i}\">{$i}</a>";
            }
        }

        // Mostrar puntos suspensivos y última página si es necesario
        if($end_page < $total_pages) {
            if ($end_page < $total_pages - 1) {
                $html .= "<span class=\"pagination__link pagination__link--dots\">...</span>";
            }
            $html .= "<a class=\"pagination__link pagination__link--number\" href=\"?page={$total_pages}\">{$total_pages}</a>";
        }

        return $html;
    }

    public function pagination() {
        $html = "";
        if($this->total_registrations > 1) {
            $html .= '<div class="pagination">';
            $html .= $this->previous_link();
            $html .= $this->numbers_pages();
            $html .= $this->next_link();
            $html .= '</div>';
        }
        return $html;
    }
}