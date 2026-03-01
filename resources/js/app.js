document.addEventListener('reload-page', () => {
    window.location.reload();
});

document.addEventListener('alpine:init', () => {
    // maskCurrency
    Alpine.data('moneyInput', (initialValue, wirePath, index) => ({
        formatted: '',
        
        init() {
            // Formatear el valor inicial que viene de Laravel
            this.formatted = this.format(initialValue.toString());
        },

        format(value) {
            // Eliminar todo lo que no sea número
            let cleanValue = value.replace(/\D/g, '');
            if (!cleanValue || cleanValue === '0') return '0.00';
            
            // Convertir a decimal (ej: 100 -> 1.00)
            let numValue = parseInt(cleanValue) / 100;
            
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(numValue);
        },

        updateValue(event) {
            // Aplicar formato
            this.formatted = this.format(event.target.value);
            
            // Valor limpio para enviar a Livewire (ej: 1250.50)
            let rawNumber = this.formatted.replace(/,/g, '');
            
            // Determinar el campo basado en el input type o usar un campo por defecto
            let fieldName = event.target.dataset.field || 'unit_price';
            
            // Usamos la ruta dinámica que pasamos por parámetro
            this.$wire.set(`${wirePath}.${index}.${fieldName}`, rawNumber);

            // Forzar cursor al final
            this.$nextTick(() => {
                event.target.setSelectionRange(this.formatted.length, this.formatted.length);
            });
        },

        forceEnd(el) {
            this.$nextTick(() => {
                el.setSelectionRange(el.value.length, el.value.length);
            });
        }
    }));
});