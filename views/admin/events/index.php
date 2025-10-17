<h2 class="dashboard__heading"><?php echo $tittle; ?></h2>

<div class="dashboard__container-button">
    <a class="dashboard__button" href="/admin/events/create">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir Evento
    </a>
</div>

<div class="dashboard__container">
    <?php if(!empty($events)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Evento</th>
                    <th scope="col" class="table__th">Categoría</th>
                    <th scope="col" class="table__th">Día y Hora</th>
                    <th scope="col" class="table__th">Ponente</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach($events as $event) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $event->name; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $event->category_name; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $event->day_name . ", " . $event->hour_name; ?>
                        </td>

                        <td class="table__td">
                            <?php echo $event->speaker_name . " " . $event->last_name; ?>
                        </td>

                        <td class="table__td--actions">
                            <a class="table__action table__action--edit" href="/admin/events/edit?id=<?php echo $event->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form method="POST" action="/admin/events/delete" class="table__form">
                                <input type="hidden" name="id" value="<?php echo $event->id; ?>">
                                <button class="table__action table__action--delete" type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">Aún No Hay Eventos</p>
    <?php } ?>
</div>

<?php
    echo $pagination;
?>