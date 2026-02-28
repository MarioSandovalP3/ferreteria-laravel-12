<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    DB::table('countries')->insert(
        ["name_es" => "Afganistán", "name_en" => "Afghanistan", "country_code" => "+93", "image" => "afganistan.png", "iso_code" => "AF", "currency" => "AFN", "currency_symbol" => "؋", "timezone" => "Asia/Kabul", "utc_offset" => "+04:30"]);
    DB::table('countries')->insert(
        ["name_es" => "Albania", "name_en" => "Albania", "country_code" => "+355", "image" => "albania.png", "iso_code" => "AL", "currency" => "ALL", "currency_symbol" => "L", "timezone" => "Europe/Tirane", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Argelia", "name_en" => "Algeria", "country_code" => "+213", "image" => "argelia.png", "iso_code" => "DZ", "currency" => "DZD", "currency_symbol" => "د.ج", "timezone" => "Africa/Algiers", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Andorra", "name_en" => "Andorra", "country_code" => "+376", "image" => "andorra.png", "iso_code" => "AD", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Andorra", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Angola", "name_en" => "Angola", "country_code" => "+244", "image" => "angola.png", "iso_code" => "AO", "currency" => "AOA", "currency_symbol" => "Kz", "timezone" => "Africa/Luanda", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Argentina", "name_en" => "Argentina", "country_code" => "+54", "image" => "argentina.png", "iso_code" => "AR", "currency" => "ARS", "currency_symbol" => "$", "timezone" => "America/Argentina/Buenos_Aires", "utc_offset" => "-03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Armenia", "name_en" => "Armenia", "country_code" => "+374", "image" => "armenia.png", "iso_code" => "AM", "currency" => "AMD", "currency_symbol" => "֏", "timezone" => "Asia/Yerevan", "utc_offset" => "+04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Aruba", "name_en" => "Aruba", "country_code" => "+297", "image" => "aruba.png", "iso_code" => "AW", "currency" => "AWG", "currency_symbol" => "ƒ", "timezone" => "America/Aruba", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Australia", "name_en" => "Australia", "country_code" => "+61", "image" => "australia.png", "iso_code" => "AU", "currency" => "AUD", "currency_symbol" => "$", "timezone" => "Australia/Sydney", "utc_offset" => "+10:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Austria", "name_en" => "Austria", "country_code" => "+43", "image" => "austria.png", "iso_code" => "AT", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Vienna", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Azerbaiyán", "name_en" => "Azerbaijan", "country_code" => "+994", "image" => "azerbaiyan.png", "iso_code" => "AZ", "currency" => "AZN", "currency_symbol" => "₼", "timezone" => "Asia/Baku", "utc_offset" => "+04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bahréin", "name_en" => "Bahrain", "country_code" => "+973", "image" => "bahrein.png", "iso_code" => "BH", "currency" => "BHD", "currency_symbol" => ".د.ب", "timezone" => "Asia/Bahrain", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bangladesh", "name_en" => "Bangladesh", "country_code" => "+880", "image" => "bangladesh.png", "iso_code" => "BD", "currency" => "BDT", "currency_symbol" => "৳", "timezone" => "Asia/Dhaka", "utc_offset" => "+06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bielorrusia", "name_en" => "Belarus", "country_code" => "+375", "image" => "bielorrusia.png", "iso_code" => "BY", "currency" => "BYN", "currency_symbol" => "Br", "timezone" => "Europe/Minsk", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bélgica", "name_en" => "Belgium", "country_code" => "+32", "image" => "belgica.png", "iso_code" => "BE", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Brussels", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Belice", "name_en" => "Belize", "country_code" => "+501", "image" => "belice.png", "iso_code" => "BZ", "currency" => "BZD", "currency_symbol" => "$", "timezone" => "America/Belize", "utc_offset" => "-06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Benín", "name_en" => "Benin", "country_code" => "+229", "image" => "benin.png", "iso_code" => "BJ", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Porto-Novo", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bután", "name_en" => "Bhutan", "country_code" => "+975", "image" => "butan.png", "iso_code" => "BT", "currency" => "BTN", "currency_symbol" => "Nu.", "timezone" => "Asia/Thimphu", "utc_offset" => "+06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bolivia", "name_en" => "Bolivia", "country_code" => "+591", "image" => "bolivia.png", "iso_code" => "BO", "currency" => "BOB", "currency_symbol" => "Bs.", "timezone" => "America/La_Paz", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bosnia y Herzegovina", "name_en" => "Bosnia and Herzegovina", "country_code" => "+387", "image" => "bosnia_y_herzegovina.png", "iso_code" => "BA", "currency" => "BAM", "currency_symbol" => "KM", "timezone" => "Europe/Sarajevo", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Botsuana", "name_en" => "Botswana", "country_code" => "+267", "image" => "botsuana.png", "iso_code" => "BW", "currency" => "BWP", "currency_symbol" => "P", "timezone" => "Africa/Gaborone", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Brasil", "name_en" => "Brazil", "country_code" => "+55", "image" => "brasil.png", "iso_code" => "BR", "currency" => "BRL", "currency_symbol" => "R$", "timezone" => "America/Sao_Paulo", "utc_offset" => "-03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Brunéi", "name_en" => "Brunei", "country_code" => "+673", "image" => "brunei.png", "iso_code" => "BN", "currency" => "BND", "currency_symbol" => "$", "timezone" => "Asia/Brunei", "utc_offset" => "+08:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Bulgaria", "name_en" => "Bulgaria", "country_code" => "+359", "image" => "bulgaria.png", "iso_code" => "BG", "currency" => "BGN", "currency_symbol" => "лв", "timezone" => "Europe/Sofia", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Burkina Faso", "name_en" => "Burkina Faso", "country_code" => "+226", "image" => "burkina_faso.png", "iso_code" => "BF", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Ouagadougou", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Burundi", "name_en" => "Burundi", "country_code" => "+257", "image" => "burundi.png", "iso_code" => "BI", "currency" => "BIF", "currency_symbol" => "FBu", "timezone" => "Africa/Bujumbura", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Camboya", "name_en" => "Cambodia", "country_code" => "+855", "image" => "camboya.png", "iso_code" => "KH", "currency" => "KHR", "currency_symbol" => "៛", "timezone" => "Asia/Phnom_Penh", "utc_offset" => "+07:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Camerún", "name_en" => "Cameroon", "country_code" => "+237", "image" => "camerun.png", "iso_code" => "CM", "currency" => "XAF", "currency_symbol" => "FCFA", "timezone" => "Africa/Douala", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Canadá", "name_en" => "Canada", "country_code" => "+1", "image" => "canada.png", "iso_code" => "CA", "currency" => "CAD", "currency_symbol" => "$", "timezone" => "America/Toronto", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Cabo Verde", "name_en" => "Cape Verde", "country_code" => "+238", "image" => "cabo_verde.png", "iso_code" => "CV", "currency" => "CVE", "currency_symbol" => "$", "timezone" => "Atlantic/Cape_Verde", "utc_offset" => "-01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "República Centroafricana", "name_en" => "Central African Republic", "country_code" => "+236", "image" => "republica_centroafricana.png", "iso_code" => "CF", "currency" => "XAF", "currency_symbol" => "FCFA", "timezone" => "Africa/Bangui", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Chad", "name_en" => "Chad", "country_code" => "+235", "image" => "chad.png", "iso_code" => "TD", "currency" => "XAF", "currency_symbol" => "FCFA", "timezone" => "Africa/Ndjamena", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Chile", "name_en" => "Chile", "country_code" => "+56", "image" => "chile.png", "iso_code" => "CL", "currency" => "CLP", "currency_symbol" => "$", "timezone" => "America/Santiago", "utc_offset" => "-03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "China", "name_en" => "China", "country_code" => "+86", "image" => "china.png", "iso_code" => "CN", "currency" => "CNY", "currency_symbol" => "¥", "timezone" => "Asia/Shanghai", "utc_offset" => "+08:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Colombia", "name_en" => "Colombia", "country_code" => "+57", "image" => "colombia.png", "iso_code" => "CO", "currency" => "COP", "currency_symbol" => "$", "timezone" => "America/Bogota", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Comoras", "name_en" => "Comoros", "country_code" => "+269", "image" => "comoras.png", "iso_code" => "KM", "currency" => "KMF", "currency_symbol" => "CF", "timezone" => "Indian/Comoro", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "República del Congo", "name_en" => "Congo Republic", "country_code" => "+242", "image" => "republica_del_congo.png", "iso_code" => "CG", "currency" => "XAF", "currency_symbol" => "FCFA", "timezone" => "Africa/Brazzaville", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "República Democrática del Congo", "name_en" => "Democratic Republic of the Congo", "country_code" => "+243", "image" => "republica_democratica_del_congo.png", "iso_code" => "CD", "currency" => "CDF", "currency_symbol" => "FC", "timezone" => "Africa/Kinshasa", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Costa Rica", "name_en" => "Costa Rica", "country_code" => "+506", "image" => "costa_rica.png", "iso_code" => "CR", "currency" => "CRC", "currency_symbol" => "₡", "timezone" => "America/Costa_Rica", "utc_offset" => "-06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Costa de Marfil", "name_en" => "Ivory Coast", "country_code" => "+225", "image" => "costa_de_marfil.png", "iso_code" => "CI", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Abidjan", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Croacia", "name_en" => "Croatia", "country_code" => "+385", "image" => "croacia.png", "iso_code" => "HR", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Zagreb", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Cuba", "name_en" => "Cuba", "country_code" => "+53", "image" => "cuba.png", "iso_code" => "CU", "currency" => "CUP", "currency_symbol" => "$", "timezone" => "America/Havana", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Chipre", "name_en" => "Cyprus", "country_code" => "+357", "image" => "chipre.png", "iso_code" => "CY", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Asia/Nicosia", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Chequia", "name_en" => "Czechia", "country_code" => "+420", "image" => "chequia.png", "iso_code" => "CZ", "currency" => "CZK", "currency_symbol" => "Kč", "timezone" => "Europe/Prague", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Dinamarca", "name_en" => "Denmark", "country_code" => "+45", "image" => "dinamarca.png", "iso_code" => "DK", "currency" => "DKK", "currency_symbol" => "kr", "timezone" => "Europe/Copenhagen", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Yibuti", "name_en" => "Djibouti", "country_code" => "+253", "image" => "yibuti.png", "iso_code" => "DJ", "currency" => "DJF", "currency_symbol" => "Fdj", "timezone" => "Africa/Djibouti", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Dominica", "name_en" => "Dominica", "country_code" => "+1 767", "image" => "dominica.png", "iso_code" => "DM", "currency" => "XCD", "currency_symbol" => "$", "timezone" => "America/Dominica", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "República Dominicana", "name_en" => "Dominican Republic", "country_code" => "+1 809", "image" => "republica_dominicana.png", "iso_code" => "DO", "currency" => "DOP", "currency_symbol" => "$", "timezone" => "America/Santo_Domingo", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Ecuador", "name_en" => "Ecuador", "country_code" => "+593", "image" => "ecuador.png", "iso_code" => "EC", "currency" => "USD", "currency_symbol" => "$", "timezone" => "America/Guayaquil", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Egipto", "name_en" => "Egypt", "country_code" => "+20", "image" => "egipto.png", "iso_code" => "EG", "currency" => "EGP", "currency_symbol" => "£", "timezone" => "Africa/Cairo", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "El Salvador", "name_en" => "El Salvador", "country_code" => "+503", "image" => "el_salvador.png", "iso_code" => "SV", "currency" => "USD", "currency_symbol" => "$", "timezone" => "America/El_Salvador", "utc_offset" => "-06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Guinea Ecuatorial", "name_en" => "Equatorial Guinea", "country_code" => "+240", "image" => "guinea_ecuatorial.png", "iso_code" => "GQ", "currency" => "XAF", "currency_symbol" => "FCFA", "timezone" => "Africa/Malabo", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Eritrea", "name_en" => "Eritrea", "country_code" => "+291", "image" => "eritrea.png", "iso_code" => "ER", "currency" => "ERN", "currency_symbol" => "Nfk", "timezone" => "Africa/Asmara", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Estonia", "name_en" => "Estonia", "country_code" => "+372", "image" => "estonia.png", "iso_code" => "EE", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Tallinn", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Eswatini", "name_en" => "Eswatini", "country_code" => "+268", "image" => "eswatini.png", "iso_code" => "SZ", "currency" => "SZL", "currency_symbol" => "L", "timezone" => "Africa/Mbabane", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Etiopía", "name_en" => "Ethiopia", "country_code" => "+251", "image" => "etiopia.png", "iso_code" => "ET", "currency" => "ETB", "currency_symbol" => "Br", "timezone" => "Africa/Addis_Ababa", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Fiyi", "name_en" => "Fiji", "country_code" => "+679", "image" => "fiyi.png", "iso_code" => "FJ", "currency" => "FJD", "currency_symbol" => "$", "timezone" => "Pacific/Fiji", "utc_offset" => "+12:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Finlandia", "name_en" => "Finland", "country_code" => "+358", "image" => "finlandia.png", "iso_code" => "FI", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Helsinki", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Francia", "name_en" => "France", "country_code" => "+33", "image" => "francia.png", "iso_code" => "FR", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Paris", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Gabón", "name_en" => "Gabon", "country_code" => "+241", "image" => "gabon.png", "iso_code" => "GA", "currency" => "XAF", "currency_symbol" => "FCFA", "timezone" => "Africa/Libreville", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Gambia", "name_en" => "Gambia", "country_code" => "+220", "image" => "gambia.png", "iso_code" => "GM", "currency" => "GMD", "currency_symbol" => "D", "timezone" => "Africa/Banjul", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Georgia", "name_en" => "Georgia", "country_code" => "+995", "image" => "georgia.png", "iso_code" => "GE", "currency" => "GEL", "currency_symbol" => "₾", "timezone" => "Asia/Tbilisi", "utc_offset" => "+04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Alemania", "name_en" => "Germany", "country_code" => "+49", "image" => "alemania.png", "iso_code" => "DE", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Berlin", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Ghana", "name_en" => "Ghana", "country_code" => "+233", "image" => "ghana.png", "iso_code" => "GH", "currency" => "GHS", "currency_symbol" => "₵", "timezone" => "Africa/Accra", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Grecia", "name_en" => "Greece", "country_code" => "+30", "image" => "grecia.png", "iso_code" => "GR", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Athens", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Granada", "name_en" => "Grenada", "country_code" => "+1 473", "image" => "granada.png", "iso_code" => "GD", "currency" => "XCD", "currency_symbol" => "$", "timezone" => "America/Grenada", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Guatemala", "name_en" => "Guatemala", "country_code" => "+502", "image" => "guatemala.png", "iso_code" => "GT", "currency" => "GTQ", "currency_symbol" => "Q", "timezone" => "America/Guatemala", "utc_offset" => "-06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Guinea", "name_en" => "Guinea", "country_code" => "+224", "image" => "guinea.png", "iso_code" => "GN", "currency" => "GNF", "currency_symbol" => "FG", "timezone" => "Africa/Conakry", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Guinea-Bisáu", "name_en" => "Guinea-Bissau", "country_code" => "+245", "image" => "guinea_bisau.png", "iso_code" => "GW", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Bissau", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Guyana", "name_en" => "Guyana", "country_code" => "+592", "image" => "guyana.png", "iso_code" => "GY", "currency" => "GYD", "currency_symbol" => "$", "timezone" => "America/Guyana", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Haití", "name_en" => "Haiti", "country_code" => "+509", "image" => "haiti.png", "iso_code" => "HT", "currency" => "HTG", "currency_symbol" => "G", "timezone" => "America/Port-au-Prince", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Honduras", "name_en" => "Honduras", "country_code" => "+504", "image" => "honduras.png", "iso_code" => "HN", "currency" => "HNL", "currency_symbol" => "L", "timezone" => "America/Tegucigalpa", "utc_offset" => "-06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Hungría", "name_en" => "Hungary", "country_code" => "+36", "image" => "hungria.png", "iso_code" => "HU", "currency" => "HUF", "currency_symbol" => "Ft", "timezone" => "Europe/Budapest", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Islandia", "name_en" => "Iceland", "country_code" => "+354", "image" => "islandia.png", "iso_code" => "IS", "currency" => "ISK", "currency_symbol" => "kr", "timezone" => "Atlantic/Reykjavik", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "India", "name_en" => "India", "country_code" => "+91", "image" => "india.png", "iso_code" => "IN", "currency" => "INR", "currency_symbol" => "₹", "timezone" => "Asia/Kolkata", "utc_offset" => "+05:30"]);
    DB::table('countries')->insert(
        ["name_es" => "Indonesia", "name_en" => "Indonesia", "country_code" => "+62", "image" => "indonesia.png", "iso_code" => "ID", "currency" => "IDR", "currency_symbol" => "Rp", "timezone" => "Asia/Jakarta", "utc_offset" => "+07:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Irán", "name_en" => "Iran", "country_code" => "+98", "image" => "iran.png", "iso_code" => "IR", "currency" => "IRR", "currency_symbol" => "﷼", "timezone" => "Asia/Tehran", "utc_offset" => "+03:30"]);
    DB::table('countries')->insert(
        ["name_es" => "Irak", "name_en" => "Iraq", "country_code" => "+964", "image" => "irak.png", "iso_code" => "IQ", "currency" => "IQD", "currency_symbol" => "ع.د", "timezone" => "Asia/Baghdad", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Irlanda", "name_en" => "Ireland", "country_code" => "+353", "image" => "irlanda.png", "iso_code" => "IE", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Dublin", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Israel", "name_en" => "Israel", "country_code" => "+972", "image" => "israel.png", "iso_code" => "IL", "currency" => "ILS", "currency_symbol" => "₪", "timezone" => "Asia/Jerusalem", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Italia", "name_en" => "Italy", "country_code" => "+39", "image" => "italia.png", "iso_code" => "IT", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Rome", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Jamaica", "name_en" => "Jamaica", "country_code" => "+1 876", "image" => "jamaica.png", "iso_code" => "JM", "currency" => "JMD", "currency_symbol" => "$", "timezone" => "America/Jamaica", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Japón", "name_en" => "Japan", "country_code" => "+81", "image" => "japon.png", "iso_code" => "JP", "currency" => "JPY", "currency_symbol" => "¥", "timezone" => "Asia/Tokyo", "utc_offset" => "+09:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Jordania", "name_en" => "Jordan", "country_code" => "+962", "image" => "jordania.png", "iso_code" => "JO", "currency" => "JOD", "currency_symbol" => "د.ا", "timezone" => "Asia/Amman", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Kazajistán", "name_en" => "Kazakhstan", "country_code" => "+7", "image" => "kazajistan.png", "iso_code" => "KZ", "currency" => "KZT", "currency_symbol" => "₸", "timezone" => "Asia/Almaty", "utc_offset" => "+06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Kenia", "name_en" => "Kenya", "country_code" => "+254", "image" => "kenia.png", "iso_code" => "KE", "currency" => "KES", "currency_symbol" => "KSh", "timezone" => "Africa/Nairobi", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Kiribati", "name_en" => "Kiribati", "country_code" => "+686", "image" => "kiribati.png", "iso_code" => "KI", "currency" => "AUD", "currency_symbol" => "$", "timezone" => "Pacific/Tarawa", "utc_offset" => "+12:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Corea del Norte", "name_en" => "North Korea", "country_code" => "+850", "image" => "corea_del_norte.png", "iso_code" => "KP", "currency" => "KPW", "currency_symbol" => "₩", "timezone" => "Asia/Pyongyang", "utc_offset" => "+09:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Corea del Sur", "name_en" => "South Korea", "country_code" => "+82", "image" => "corea_del_sur.png", "iso_code" => "KR", "currency" => "KRW", "currency_symbol" => "₩", "timezone" => "Asia/Seoul", "utc_offset" => "+09:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Kosovo", "name_en" => "Kosovo", "country_code" => "+383", "image" => "kosovo.png", "iso_code" => "XK", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Belgrade", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Kuwait", "name_en" => "Kuwait", "country_code" => "+965", "image" => "kuwait.png", "iso_code" => "KW", "currency" => "KWD", "currency_symbol" => "د.ك", "timezone" => "Asia/Kuwait", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Kirguistán", "name_en" => "Kyrgyzstan", "country_code" => "+996", "image" => "kirguistan.png", "iso_code" => "KG", "currency" => "KGS", "currency_symbol" => "с", "timezone" => "Asia/Bishkek", "utc_offset" => "+06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Laos", "name_en" => "Laos", "country_code" => "+856", "image" => "laos.png", "iso_code" => "LA", "currency" => "LAK", "currency_symbol" => "₭", "timezone" => "Asia/Vientiane", "utc_offset" => "+07:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Letonia", "name_en" => "Latvia", "country_code" => "+371", "image" => "letonia.png", "iso_code" => "LV", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Riga", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Líbano", "name_en" => "Lebanon", "country_code" => "+961", "image" => "libano.png", "iso_code" => "LB", "currency" => "LBP", "currency_symbol" => "ل.ل", "timezone" => "Asia/Beirut", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Lesoto", "name_en" => "Lesotho", "country_code" => "+266", "image" => "lesoto.png", "iso_code" => "LS", "currency" => "LSL", "currency_symbol" => "L", "timezone" => "Africa/Maseru", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Liberia", "name_en" => "Liberia", "country_code" => "+231", "image" => "liberia.png", "iso_code" => "LR", "currency" => "LRD", "currency_symbol" => "$", "timezone" => "Africa/Monrovia", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Libia", "name_en" => "Libya", "country_code" => "+218", "image" => "libia.png", "iso_code" => "LY", "currency" => "LYD", "currency_symbol" => "ل.د", "timezone" => "Africa/Tripoli", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Liechtenstein", "name_en" => "Liechtenstein", "country_code" => "+423", "image" => "liechtenstein.png", "iso_code" => "LI", "currency" => "CHF", "currency_symbol" => "CHF", "timezone" => "Europe/Vaduz", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Lituania", "name_en" => "Lithuania", "country_code" => "+370", "image" => "lituania.png", "iso_code" => "LT", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Vilnius", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Luxemburgo", "name_en" => "Luxembourg", "country_code" => "+352", "image" => "luxemburgo.png", "iso_code" => "LU", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Luxembourg", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Madagascar", "name_en" => "Madagascar", "country_code" => "+261", "image" => "madagascar.png", "iso_code" => "MG", "currency" => "MGA", "currency_symbol" => "Ar", "timezone" => "Indian/Antananarivo", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Malaui", "name_en" => "Malawi", "country_code" => "+265", "image" => "malaui.png", "iso_code" => "MW", "currency" => "MWK", "currency_symbol" => "MK", "timezone" => "Africa/Blantyre", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Malasia", "name_en" => "Malaysia", "country_code" => "+60", "image" => "malasia.png", "iso_code" => "MY", "currency" => "MYR", "currency_symbol" => "RM", "timezone" => "Asia/Kuala_Lumpur", "utc_offset" => "+08:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Maldivas", "name_en" => "Maldives", "country_code" => "+960", "image" => "maldivas.png", "iso_code" => "MV", "currency" => "MVR", "currency_symbol" => "Rf", "timezone" => "Indian/Maldives", "utc_offset" => "+05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Malí", "name_en" => "Mali", "country_code" => "+223", "image" => "mali.png", "iso_code" => "ML", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Bamako", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Malta", "name_en" => "Malta", "country_code" => "+356", "image" => "malta.png", "iso_code" => "MT", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Malta", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Islas Marshall", "name_en" => "Marshall Islands", "country_code" => "+692", "image" => "islas_marshall.png", "iso_code" => "MH", "currency" => "USD", "currency_symbol" => "$", "timezone" => "Pacific/Majuro", "utc_offset" => "+12:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Mauritania", "name_en" => "Mauritania", "country_code" => "+222", "image" => "mauritania.png", "iso_code" => "MR", "currency" => "MRU", "currency_symbol" => "UM", "timezone" => "Africa/Nouakchott", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Mauricio", "name_en" => "Mauritius", "country_code" => "+230", "image" => "mauricio.png", "iso_code" => "MU", "currency" => "MUR", "currency_symbol" => "₨", "timezone" => "Indian/Mauritius", "utc_offset" => "+04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "México", "name_en" => "Mexico", "country_code" => "+52", "image" => "mexico.png", "iso_code" => "MX", "currency" => "MXN", "currency_symbol" => "$", "timezone" => "America/Mexico_City", "utc_offset" => "-06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Micronesia", "name_en" => "Micronesia", "country_code" => "+691", "image" => "micronesia.png", "iso_code" => "FM", "currency" => "USD", "currency_symbol" => "$", "timezone" => "Pacific/Chuuk", "utc_offset" => "+10:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Moldavia", "name_en" => "Moldova", "country_code" => "+373", "image" => "moldavia.png", "iso_code" => "MD", "currency" => "MDL", "currency_symbol" => "L", "timezone" => "Europe/Chisinau", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Mónaco", "name_en" => "Monaco", "country_code" => "+377", "image" => "monaco.png", "iso_code" => "MC", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Monaco", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Mongolia", "name_en" => "Mongolia", "country_code" => "+976", "image" => "mongolia.png", "iso_code" => "MN", "currency" => "MNT", "currency_symbol" => "₮", "timezone" => "Asia/Ulaanbaatar", "utc_offset" => "+08:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Montenegro", "name_en" => "Montenegro", "country_code" => "+382", "image" => "montenegro.png", "iso_code" => "ME", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Podgorica", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Marruecos", "name_en" => "Morocco", "country_code" => "+212", "image" => "marruecos.png", "iso_code" => "MA", "currency" => "MAD", "currency_symbol" => "د.م.", "timezone" => "Africa/Casablanca", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Mozambique", "name_en" => "Mozambique", "country_code" => "+258", "image" => "mozambique.png", "iso_code" => "MZ", "currency" => "MZN", "currency_symbol" => "MT", "timezone" => "Africa/Maputo", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Birmania", "name_en" => "Myanmar", "country_code" => "+95", "image" => "birmania.png", "iso_code" => "MM", "currency" => "MMK", "currency_symbol" => "K", "timezone" => "Asia/Yangon", "utc_offset" => "+06:30"]);
    DB::table('countries')->insert(
        ["name_es" => "Namibia", "name_en" => "Namibia", "country_code" => "+264", "image" => "namibia.png", "iso_code" => "NA", "currency" => "NAD", "currency_symbol" => "$", "timezone" => "Africa/Windhoek", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Nauru", "name_en" => "Nauru", "country_code" => "+674", "image" => "nauru.png", "iso_code" => "NR", "currency" => "AUD", "currency_symbol" => "$", "timezone" => "Pacific/Nauru", "utc_offset" => "+12:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Nepal", "name_en" => "Nepal", "country_code" => "+977", "image" => "nepal.png", "iso_code" => "NP", "currency" => "NPR", "currency_symbol" => "₨", "timezone" => "Asia/Kathmandu", "utc_offset" => "+05:45"]);
    DB::table('countries')->insert(
        ["name_es" => "Países Bajos", "name_en" => "Netherlands", "country_code" => "+31", "image" => "paises_bajos.png", "iso_code" => "NL", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Amsterdam", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Nueva Zelanda", "name_en" => "New Zealand", "country_code" => "+64", "image" => "nueva_zelanda.png", "iso_code" => "NZ", "currency" => "NZD", "currency_symbol" => "$", "timezone" => "Pacific/Auckland", "utc_offset" => "+12:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Nicaragua", "name_en" => "Nicaragua", "country_code" => "+505", "image" => "nicaragua.png", "iso_code" => "NI", "currency" => "NIO", "currency_symbol" => "C$", "timezone" => "America/Managua", "utc_offset" => "-06:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Níger", "name_en" => "Niger", "country_code" => "+227", "image" => "niger.png", "iso_code" => "NE", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Niamey", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Nigeria", "name_en" => "Nigeria", "country_code" => "+234", "image" => "nigeria.png", "iso_code" => "NG", "currency" => "NGN", "currency_symbol" => "₦", "timezone" => "Africa/Lagos", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Noruega", "name_en" => "Norway", "country_code" => "+47", "image" => "noruega.png", "iso_code" => "NO", "currency" => "NOK", "currency_symbol" => "kr", "timezone" => "Europe/Oslo", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Omán", "name_en" => "Oman", "country_code" => "+968", "image" => "oman.png", "iso_code" => "OM", "currency" => "OMR", "currency_symbol" => "ر.ع.", "timezone" => "Asia/Muscat", "utc_offset" => "+04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Pakistán", "name_en" => "Pakistan", "country_code" => "+92", "image" => "pakistan.png", "iso_code" => "PK", "currency" => "PKR", "currency_symbol" => "₨", "timezone" => "Asia/Karachi", "utc_offset" => "+05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Palaos", "name_en" => "Palau", "country_code" => "+680", "image" => "palaos.png", "iso_code" => "PW", "currency" => "USD", "currency_symbol" => "$", "timezone" => "Pacific/Palau", "utc_offset" => "+09:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Palestina", "name_en" => "Palestine", "country_code" => "+970", "image" => "palestina.png", "iso_code" => "PS", "currency" => "ILS", "currency_symbol" => "₪", "timezone" => "Asia/Gaza", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Panamá", "name_en" => "Panama", "country_code" => "+507", "image" => "panama.png", "iso_code" => "PA", "currency" => "PAB", "currency_symbol" => "B/.", "timezone" => "America/Panama", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Papúa Nueva Guinea", "name_en" => "Papua New Guinea", "country_code" => "+675", "image" => "papua_nueva_guinea.png", "iso_code" => "PG", "currency" => "PGK", "currency_symbol" => "K", "timezone" => "Pacific/Port_Moresby", "utc_offset" => "+10:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Paraguay", "name_en" => "Paraguay", "country_code" => "+595", "image" => "paraguay.png", "iso_code" => "PY", "currency" => "PYG", "currency_symbol" => "₲", "timezone" => "America/Asuncion", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Perú", "name_en" => "Peru", "country_code" => "+51", "image" => "peru.png", "iso_code" => "PE", "currency" => "PEN", "currency_symbol" => "S/.", "timezone" => "America/Lima", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Filipinas", "name_en" => "Philippines", "country_code" => "+63", "image" => "filipinas.png", "iso_code" => "PH", "currency" => "PHP", "currency_symbol" => "₱", "timezone" => "Asia/Manila", "utc_offset" => "+08:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Polonia", "name_en" => "Poland", "country_code" => "+48", "image" => "polonia.png", "iso_code" => "PL", "currency" => "PLN", "currency_symbol" => "zł", "timezone" => "Europe/Warsaw", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Portugal", "name_en" => "Portugal", "country_code" => "+351", "image" => "portugal.png", "iso_code" => "PT", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Lisbon", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Catar", "name_en" => "Qatar", "country_code" => "+974", "image" => "catar.png", "iso_code" => "QA", "currency" => "QAR", "currency_symbol" => "ر.ق", "timezone" => "Asia/Qatar", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Rumania", "name_en" => "Romania", "country_code" => "+40", "image" => "rumania.png", "iso_code" => "RO", "currency" => "RON", "currency_symbol" => "lei", "timezone" => "Europe/Bucharest", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Rusia", "name_en" => "Russia", "country_code" => "+7", "image" => "rusia.png", "iso_code" => "RU", "currency" => "RUB", "currency_symbol" => "₽", "timezone" => "Europe/Moscow", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Ruanda", "name_en" => "Rwanda", "country_code" => "+250", "image" => "ruanda.png", "iso_code" => "RW", "currency" => "RWF", "currency_symbol" => "FRw", "timezone" => "Africa/Kigali", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "San Cristóbal y Nieves", "name_en" => "Saint Kitts and Nevis", "country_code" => "+1 869", "image" => "san_cristobal_y_nieves.png", "iso_code" => "KN", "currency" => "XCD", "currency_symbol" => "$", "timezone" => "America/St_Kitts", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Santa Lucía", "name_en" => "Saint Lucia", "country_code" => "+1 758", "image" => "santa_lucia.png", "iso_code" => "LC", "currency" => "XCD", "currency_symbol" => "$", "timezone" => "America/St_Lucia", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "San Vicente y las Granadinas", "name_en" => "Saint Vincent and the Grenadines", "country_code" => "+1 784", "image" => "san_vicente_y_las_granadinas.png", "iso_code" => "VC", "currency" => "XCD", "currency_symbol" => "$", "timezone" => "America/St_Vincent", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Samoa", "name_en" => "Samoa", "country_code" => "+685", "image" => "samoa.png", "iso_code" => "WS", "currency" => "WST", "currency_symbol" => "T", "timezone" => "Pacific/Apia", "utc_offset" => "+13:00"]);
    DB::table('countries')->insert(
        ["name_es" => "San Marino", "name_en" => "San Marino", "country_code" => "+378", "image" => "san_marino.png", "iso_code" => "SM", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/San_Marino", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Santo Tomé y Príncipe", "name_en" => "São Tomé and Príncipe", "country_code" => "+239", "image" => "santo_tome_y_principe.png", "iso_code" => "ST", "currency" => "STN", "currency_symbol" => "Db", "timezone" => "Africa/Sao_Tome", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Arabia Saudita", "name_en" => "Saudi Arabia", "country_code" => "+966", "image" => "arabia_saudita.png", "iso_code" => "SA", "currency" => "SAR", "currency_symbol" => "ر.س", "timezone" => "Asia/Riyadh", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Senegal", "name_en" => "Senegal", "country_code" => "+221", "image" => "senegal.png", "iso_code" => "SN", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Dakar", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Serbia", "name_en" => "Serbia", "country_code" => "+381", "image" => "serbia.png", "iso_code" => "RS", "currency" => "RSD", "currency_symbol" => "дин.", "timezone" => "Europe/Belgrade", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Seychelles", "name_en" => "Seychelles", "country_code" => "+248", "image" => "seychelles.png", "iso_code" => "SC", "currency" => "SCR", "currency_symbol" => "₨", "timezone" => "Indian/Mahé", "utc_offset" => "+04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Sierra Leona", "name_en" => "Sierra Leone", "country_code" => "+232", "image" => "sierra_leona.png", "iso_code" => "SL", "currency" => "SLL", "currency_symbol" => "Le", "timezone" => "Africa/Freetown", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Singapur", "name_en" => "Singapore", "country_code" => "+65", "image" => "singapur.png", "iso_code" => "SG", "currency" => "SGD", "currency_symbol" => "$", "timezone" => "Asia/Singapore", "utc_offset" => "+08:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Eslovaquia", "name_en" => "Slovakia", "country_code" => "+421", "image" => "eslovaquia.png", "iso_code" => "SK", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Bratislava", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Eslovenia", "name_en" => "Slovenia", "country_code" => "+386", "image" => "eslovenia.png", "iso_code" => "SI", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Ljubljana", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Islas Salomón", "name_en" => "Solomon Islands", "country_code" => "+677", "image" => "islas_salomon.png", "iso_code" => "SB", "currency" => "SBD", "currency_symbol" => "$", "timezone" => "Pacific/Guadalcanal", "utc_offset" => "+11:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Somalia", "name_en" => "Somalia", "country_code" => "+252", "image" => "somalia.png", "iso_code" => "SO", "currency" => "SOS", "currency_symbol" => "S", "timezone" => "Africa/Mogadishu", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Sudáfrica", "name_en" => "South Africa", "country_code" => "+27", "image" => "sudafrica.png", "iso_code" => "ZA", "currency" => "ZAR", "currency_symbol" => "R", "timezone" => "Africa/Johannesburg", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Sudán del Sur", "name_en" => "South Sudan", "country_code" => "+211", "image" => "sudan_del_sur.png", "iso_code" => "SS", "currency" => "SSP", "currency_symbol" => "£", "timezone" => "Africa/Juba", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "España", "name_en" => "Spain", "country_code" => "+34", "image" => "espana.png", "iso_code" => "ES", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Madrid", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Sri Lanka", "name_en" => "Sri Lanka", "country_code" => "+94", "image" => "sri_lanka.png", "iso_code" => "LK", "currency" => "LKR", "currency_symbol" => "₨", "timezone" => "Asia/Colombo", "utc_offset" => "+05:30"]);
    DB::table('countries')->insert(
        ["name_es" => "Sudán", "name_en" => "Sudan", "country_code" => "+249", "image" => "sudan.png", "iso_code" => "SD", "currency" => "SDG", "currency_symbol" => "£", "timezone" => "Africa/Khartoum", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Surinam", "name_en" => "Suriname", "country_code" => "+597", "image" => "surinam.png", "iso_code" => "SR", "currency" => "SRD", "currency_symbol" => "$", "timezone" => "America/Paramaribo", "utc_offset" => "-03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Suazilandia", "name_en" => "Swaziland", "country_code" => "+268", "image" => "suazilandia.png", "iso_code" => "SZ", "currency" => "SZL", "currency_symbol" => "L", "timezone" => "Africa/Mbabane", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Suecia", "name_en" => "Sweden", "country_code" => "+46", "image" => "suecia.png", "iso_code" => "SE", "currency" => "SEK", "currency_symbol" => "kr", "timezone" => "Europe/Stockholm", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Suiza", "name_en" => "Switzerland", "country_code" => "+41", "image" => "suiza.png", "iso_code" => "CH", "currency" => "CHF", "currency_symbol" => "CHF", "timezone" => "Europe/Zurich", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Siria", "name_en" => "Syria", "country_code" => "+963", "image" => "siria.png", "iso_code" => "SY", "currency" => "SYP", "currency_symbol" => "£", "timezone" => "Asia/Damascus", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Tayikistán", "name_en" => "Tajikistan", "country_code" => "+992", "image" => "tayikistan.png", "iso_code" => "TJ", "currency" => "TJS", "currency_symbol" => "ЅМ", "timezone" => "Asia/Dushanbe", "utc_offset" => "+05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Tanzania", "name_en" => "Tanzania", "country_code" => "+255", "image" => "tanzania.png", "iso_code" => "TZ", "currency" => "TZS", "currency_symbol" => "TSh", "timezone" => "Africa/Dar_es_Salaam", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Tailandia", "name_en" => "Thailand", "country_code" => "+66", "image" => "tailandia.png", "iso_code" => "TH", "currency" => "THB", "currency_symbol" => "฿", "timezone" => "Asia/Bangkok", "utc_offset" => "+07:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Timor-Leste", "name_en" => "Timor-Leste", "country_code" => "+670", "image" => "timor_leste.png", "iso_code" => "TL", "currency" => "USD", "currency_symbol" => "$", "timezone" => "Asia/Dili", "utc_offset" => "+09:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Togo", "name_en" => "Togo", "country_code" => "+228", "image" => "togo.png", "iso_code" => "TG", "currency" => "XOF", "currency_symbol" => "CFA", "timezone" => "Africa/Lome", "utc_offset" => "+00:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Tokelau", "name_en" => "Tokelau", "country_code" => "+690", "image" => "tokelau.png", "iso_code" => "TK", "currency" => "NZD", "currency_symbol" => "$", "timezone" => "Pacific/Fakaofo", "utc_offset" => "+13:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Tonga", "name_en" => "Tonga", "country_code" => "+676", "image" => "tonga.png", "iso_code" => "TO", "currency" => "TOP", "currency_symbol" => "T$", "timezone" => "Pacific/Tongatapu", "utc_offset" => "+13:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Trinidad y Tobago", "name_en" => "Trinidad and Tobago", "country_code" => "+1 868", "image" => "trinidad_y_tobago.png", "iso_code" => "TT", "currency" => "TTD", "currency_symbol" => "$", "timezone" => "America/Port_of_Spain", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Túnez", "name_en" => "Tunisia", "country_code" => "+216", "image" => "tunez.png", "iso_code" => "TN", "currency" => "TND", "currency_symbol" => "د.ت", "timezone" => "Africa/Tunis", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Turquía", "name_en" => "Turkey", "country_code" => "+90", "image" => "turquia.png", "iso_code" => "TR", "currency" => "TRY", "currency_symbol" => "₺", "timezone" => "Europe/Istanbul", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Turkmenistán", "name_en" => "Turkmenistan", "country_code" => "+993", "image" => "turkmenistan.png", "iso_code" => "TM", "currency" => "TMT", "currency_symbol" => "m", "timezone" => "Asia/Ashgabat", "utc_offset" => "+05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Tuvalu", "name_en" => "Tuvalu", "country_code" => "+688", "image" => "tuvalu.png", "iso_code" => "TV", "currency" => "AUD", "currency_symbol" => "$", "timezone" => "Pacific/Funafuti", "utc_offset" => "+12:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Uganda", "name_en" => "Uganda", "country_code" => "+256", "image" => "uganda.png", "iso_code" => "UG", "currency" => "UGX", "currency_symbol" => "USh", "timezone" => "Africa/Kampala", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Ucrania", "name_en" => "Ukraine", "country_code" => "+380", "image" => "ucrania.png", "iso_code" => "UA", "currency" => "UAH", "currency_symbol" => "₴", "timezone" => "Europe/Kyiv", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Emiratos Árabes Unidos", "name_en" => "United Arab Emirates", "country_code" => "+971", "image" => "emiratos_arabes_unidos.png", "iso_code" => "AE", "currency" => "AED", "currency_symbol" => "د.إ", "timezone" => "Asia/Dubai", "utc_offset" => "+04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Reino Unido", "name_en" => "United Kingdom", "country_code" => "+44", "image" => "reino_unido.png", "iso_code" => "GB", "currency" => "GBP", "currency_symbol" => "£", "timezone" => "Europe/London", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Estados Unidos", "name_en" => "United States", "country_code" => "+1", "image" => "estados_unidos.png", "iso_code" => "US", "currency" => "USD", "currency_symbol" => "$", "timezone" => "America/New_York", "utc_offset" => "-05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Uruguay", "name_en" => "Uruguay", "country_code" => "+598", "image" => "uruguay.png", "iso_code" => "UY", "currency" => "UYU", "currency_symbol" => "$", "timezone" => "America/Montevideo", "utc_offset" => "-03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Uzbekistán", "name_en" => "Uzbekistan", "country_code" => "+998", "image" => "uzbekistan.png", "iso_code" => "UZ", "currency" => "UZS", "currency_symbol" => "so'm", "timezone" => "Asia/Tashkent", "utc_offset" => "+05:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Vanuatu", "name_en" => "Vanuatu", "country_code" => "+678", "image" => "vanuatu.png", "iso_code" => "VU", "currency" => "VUV", "currency_symbol" => "VT", "timezone" => "Pacific/Efate", "utc_offset" => "+11:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Ciudad del Vaticano", "name_en" => "Vatican City", "country_code" => "+379", "image" => "ciudad_del_vaticano.png", "iso_code" => "VA", "currency" => "EUR", "currency_symbol" => "€", "timezone" => "Europe/Vatican", "utc_offset" => "+01:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Venezuela", "name_en" => "Venezuela", "country_code" => "+58", "image" => "venezuela.png", "iso_code" => "VE", "currency" => "VES", "currency_symbol" => "Bs. S", "timezone" => "America/Caracas", "utc_offset" => "-04:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Vietnam", "name_en" => "Vietnam", "country_code" => "+84", "image" => "vietnam.png", "iso_code" => "VN", "currency" => "VND", "currency_symbol" => "₫", "timezone" => "Asia/Ho_Chi_Minh", "utc_offset" => "+07:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Wallis y Futuna", "name_en" => "Wallis and Futuna", "country_code" => "+681", "image" => "wallis_y_futuna.png", "iso_code" => "WF", "currency" => "XPF", "currency_symbol" => "₣", "timezone" => "Pacific/Wallis", "utc_offset" => "+12:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Yemen", "name_en" => "Yemen", "country_code" => "+967", "image" => "yemen.png", "iso_code" => "YE", "currency" => "YER", "currency_symbol" => "﷼", "timezone" => "Asia/Aden", "utc_offset" => "+03:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Zambia", "name_en" => "Zambia", "country_code" => "+260", "image" => "zambia.png", "iso_code" => "ZM", "currency" => "ZMW", "currency_symbol" => "ZK", "timezone" => "Africa/Lusaka", "utc_offset" => "+02:00"]);
    DB::table('countries')->insert(
        ["name_es" => "Zimbabue", "name_en" => "Zimbabwe", "country_code" => "+263", "image" => "zimbabue.png", "iso_code" => "ZW", "currency" => "ZWL", "currency_symbol" => "$", "timezone" => "Africa/Harare", "utc_offset" => "+02:00"]
    );
}
}