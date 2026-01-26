
<style>
.horno-card {
    min-height: 250px;
}

.horno-title {
    font-family: 'DS-Digital', monospace;
    font-size: 28px;
    font-weight: 900;
    letter-spacing: 3px;
}

.horno-temp {
    font-family: 'DS-Digital', monospace;
    font-size: 22px;
    font-weight: 700;
}

.horno-progress {
    height: 8px;
    border-radius: 0;
    background-color: #d6d6d6;
}

.horno-fechas {
    font-size: 13px;
    color: #555;
    margin-top: 6px;
}

.horno-table th {
    font-size: 11px;
    font-weight: 600;
    color: #666;
    padding-bottom: 2px;
}

.horno-table td {
    font-size: 12px;
    padding-top: 2px;
}

.horno-refresh {
    position: absolute;
    bottom: 10px;
    right: 10px;
}

.horno-refresh i {
    font-size: 22px;
}

.horno-separador {
    border-top: 1px dotted #bdbdbd;
    margin: 10px 0px 0;  /* ↑↓  ←→  */
}

.horno-fecha {
    font-size: 15px;
    font-weight: 600;
}

.horno-arrow {
    width: 34px;
    height: 34px;
    background-color: #fd7e14;
    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 3px;
    text-decoration: none;
    font-size: 14px;
    line-height: 1;
}

.btn-orange {
    background-color: #fd7e14;
    color: #fff;
}

</style>

<x-layout2>

    @livewire('horno')

</x-layout2>