[![](https://scdn.rapidapi.com/RapidAPI_banner.png)](https://rapidapi.com/package/Yandex/functions?utm_source=RapidAPIGitHub_YandexFunctions&utm_medium=button&utm_content=RapidAPI_GitHub)

# YandexGeocoder Package
Yandex is a Russian multinational technology company specializing in Internet-related services and products. Yandex operates the largest search engine in Russia with about 65% market share in that country.The Geocoder can get a geo object's coordinates from its address, or the reverse – determine the address from the coordinates.
* Domain: [yandex.com](https://yandex.com)



## How to get credentials:
1. Navigate to [Developers Console](https://developer.tech.yandex.com/keys).
2. Create API app.

## Custom datatypes:
  |Datatype|Description|Example
  |--------|-----------|----------
  |Datepicker|String which includes date and time|```2016-05-28 00:00:00```
  |Map|String which includes latitude and longitude coma separated|```50.37, 26.56```
  |List|Simple array|```["123", "sample"]```
  |Select|String with predefined values|```sample```
  |Array|Array of objects|```[{"Second name":"123","Age":"12","Photo":"sdf","Draft":"sdfsdf"},{"name":"adi","Second name":"bla","Age":"4","Photo":"asfserwe","Draft":"sdfsdf"}] ```

## YandexGeocoder.getAddressByCoordinates
Convert a location's coordinates on the map to an address string.

| Field      | Type       | Description
|------------|------------|----------
| coordinates| Map        | The latitude and longitude of the find place.
| apiKey     | String| The key obtained in the developer's office. Used only in the paid API version. Used only in the commercial version of the API.
| centerMap         | Map        | Longitude and latitude of the center of the map in degrees.
| searchAreaSize        | String     | The length of the map display area by longitude and latitude (in degrees).
| searchAreaRestriction       | List     | A sign of a 'hard' limitation of the search area.
| results    | Number     | Number of objects returned. The default is 10. The maximum allowable value is 500.
| language       | String     | Preferred response language. List of supported values: tr_TR — Turkish (only for maps of Turkey); en_RU — United States; en_US — American English; ru_RU — Russian (by default); uk_UA — Ukrainian; be_BY — Belarusian;
| toponymType       | String     | Type of toponym (only for reverse geocoding). Acceptable values: house - house or building; street - street; metro - subway station; district - city district; locality - locality (city, town, village, etc.).
| alternativeSearch   | String | In this case, the borders of the area are defined as the geographical coordinates of the lower-left and upper-right corners of the area (in the order longitude, latitutude).

## YandexGeocoder.getCoordinatesByAddress
Convert address to coordinates.

| Field   | Type       | Description
|---------|------------|----------
| address | String     | The exact address that you want to geocode.
| apiKey  | String| The key obtained in the developer's office. Used only in the paid API version. Used only in the commercial version of the API
| searchAreaSize     | String     | The length of the map display area by longitude and latitude (in degrees).
| searchAreaRestriction    | List     | A sign of a 'hard' limitation of the search area.
| results | Number     | Number of objects returned. The default is 10. The maximum allowable value is 500.
| language    | String     | Preferred response language.
| orderCoordinates   | String | The order coordinates are specified in (only for reverse geocoding).Example : sco=latlong.
| alternativeSearch   | String | In this case, the borders of the area are defined as the geographical coordinates of the lower-left and upper-right corners of the area (in the order longitude, latitutude).
