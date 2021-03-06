@extends('layouts.app')

@section('title', config('app.name', 'Laravel') . ': Створення Вашого помешкання')

@section('content')
    <div class="container">

        <h1 class="profile--title">Створення Вашого помешкання</h1>

            <form action="/profile/apartments/create" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <label for="name" class="col-form-label">Назва</label>
                        </div>

                        <div>
                            <input id="name"
                                   type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   name="name"
                                   required
                                   value="{{ old('name') }}" autocomplete="name">

                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row">
                            <label for="type" class="col-form-label">Тип помешкання</label>
                        </div>

                        <select
                            class="form-select @error('type') is-invalid @enderror"
                            name="type"
                            required>
                            <option value="">Оберіть тип помешкання</option>

                            <option {{ old('type') == 'apartment' ? 'selected' : '' }} value="apartment">Апаратаменти</option>
                            <option {{ old('type') == 'hotel' ? 'selected' : '' }} value="hotel">Готель</option>
                            <option {{ old('type') == 'holiday_homes' ? 'selected' : '' }} value="holiday_homes">Будинок для відпочинку</option>
                            <option {{ old('type') == 'guest_house' ? 'selected' : '' }} value="guest_house">Гостьовий будинок</option>
                            <option {{ old('type') == 'hostel' ? 'selected' : '' }} value="hostel">Хостел</option>
                            <option {{ old('type') == 'villa' ? 'selected' : '' }} value="villa">Вілла</option>
                            <option {{ old('type') == 'in_a_family' ? 'selected' : '' }} value="in_a_family">Розміщення в сім'ї</option>
                            <option {{ old('type') == 'bed_and_breakfast' ? 'selected' : '' }} value="bed_and_breakfast">Готель типу "ліжко і сніданок"</option>
                            <option {{ old('type') == 'camping' ? 'selected' : '' }} value="camping">Кемпінг</option>
                            <option {{ old('type') == 'country_house' ? 'selected' : '' }} value="country_house">Заміський будинок</option>
                            <option {{ old('type') == 'resort_hotel' ? 'selected' : '' }} value="resort_hotel">Курортний готель</option>
                            <option {{ old('type') == 'park_hotel' ? 'selected' : '' }} value="park_hotel">Парк-готель</option>
                        </select>

                        @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div class="row">
                            <label for="city" class="col-form-label">Місто</label>
                        </div>

                        <select class="form-select @error('city') is-invalid @enderror"
                                name="city"
                                required>
                            <option value="">Оберіть місто</option>

                            @foreach($cities as $city)
                                <option
                                    {{ old('city') == $city->id ? 'selected' : '' }}
                                    value="{{ $city->id }}"
                                    data-subtext="{{ $city->city }}">
                                    {{ $city->city }} ({{ $city->area }})
                                </option>
                            @endforeach
                        </select>

                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <div class="row">
                            <label for="address" class="col-form-label">Адреса</label>
                        </div>

                        <div>
                            <input id="address"
                                   type="text"
                                   required
                                   class="form-control @error('address') is-invalid @enderror"
                                   name="address"
                                   value="{{ old('address') }}" autocomplete="name">

                            @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row">
                            <label for="description" class="col-form-label">Опис помешкання</label>
                        </div>

                        <div>
                            <textarea
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"
                                required
                                name="description"
                                rows="5">
                                {{ trim(old('description')) }}
                            </textarea>

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="image-upload">
                            <p class="image-upload--title">Додайте зображення готелю</p>

                            <div class="image-upload-list">
                                <div class="row">
                                    <div class="col-4 mb-3" v-for="src in previews">
                                        <div class="image-upload-list-item">
                                            <img
                                                class="image-upload-list-item--img"
                                                v-if="src && src.length" :src="src"
                                                alt="">
                                            <p class="image-upload-list-item--hided">Видалити</p>
                                        </div>
                                    </div>

                                    <label for="photos">
                                        <div class="col-12">
                                            <div class="image-upload-list--add btn btn-second w-100 mt-1 py-2">
                                                Додати фото (максимум 10)
                                            </div>
                                        </div>
                                    </label>

                                    <input type="file" class="form-control-file d-none" id="photos" name="photos[]" multiple required>
                                </div>
                            </div>
                        </div>

                        @error('photos')
                            <strong>{{ $message }}</strong>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4">
                        <p class="hotel-features--title">Харчування</p>

                        <ul class="hotel-features-list list-unstyled">
                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="food_with_own_kitchen">З власною кухнею</label>
                                <input type="checkbox" name="food_with_own_kitchen" value="1" id="food_with_own_kitchen" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="food_breakfast_is_included">Сніданок включено</label>
                                <input type="checkbox" name="food_breakfast_is_included" value="1" id="food_breakfast_is_included" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="food_restaurant">Ресторан</label>
                                <input type="checkbox" name="food_restaurant" value="1" id="food_restaurant" class="hotel-features-list--item__checkbox--checkbox">
                            </li>
                        </ul>
                    </div>

                    <div class="col-4">
                        <p class="hotel-features--title">Інтернет</p>

                        <ul class="hotel-features-list list-unstyled">
                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="internet_free_wifi">Безкоштовний Wi-Fi</label>
                                <input type="checkbox" name="internet_free_wifi" value="1" id="internet_free_wifi" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="internet_fixed">Фіксований Інтернет</label>
                                <input type="checkbox" name="internet_fixed" value="1" id="internet_fixed" class="hotel-features-list--item__checkbox--checkbox">
                            </li>
                        </ul>
                    </div>

                    <div class="col-4">
                        <p class="hotel-features--title">Транспорт</p>

                        <ul class="hotel-features-list list-unstyled">
                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="transport_free_parking">Безкоштовна автостоянка</label>
                                <input type="checkbox" name="transport_free_parking" value="1" id="transport_free_parking" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="transport_paid_parking">Платна автостоянка</label>
                                <input type="checkbox" name="transport_paid_parking" value="1" id="transport_paid_parking" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="transport_e_station">Станція для заряджання електромобілів</label>
                                <input type="checkbox" name="transport_e_station" value="1" id="transport_e_station" class="hotel-features-list--item__checkbox--checkbox">
                            </li>
                        </ul>
                    </div>

                    <div class="col-4">
                        <p class="hotel-features--title">Спорт та дозвілля</p>

                        <ul class="hotel-features-list list-unstyled">
                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="sports_leisure_fitness">Фітнес-центр</label>
                                <input type="checkbox" name="sports_leisure_fitness" value="1" id="sports_leisure_fitness" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="sports_leisure_basin">Басейн</label>
                                <input type="checkbox" name="sports_leisure_basin" value="1" id="sports_leisure_basin" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="sports_leisure_health_spa">Оздоровчий спа-центр</label>
                                <input type="checkbox" name="sports_leisure_health_spa" value="1" id="sports_leisure_health_spa" class="hotel-features-list--item__checkbox--checkbox">
                            </li>
                        </ul>
                    </div>

                    <div class="col-4">
                        <p class="hotel-features--title">Інше</p>

                        <ul class="hotel-features-list list-unstyled">
                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="other_pets_allowed">Дозволене розміщення з домашніми тваринами</label>
                                <input type="checkbox" name="other_pets_allowed" value="1" id="other_pets_allowed" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="other_cleaning">Прибирання</label>
                                <input type="checkbox" name="other_cleaning" value="1" id="other_cleaning" class="hotel-features-list--item__checkbox--checkbox">
                            </li>

                            <li class="hotel-features-list--item hotel-features-list--item__checkbox">
                                <label for="other_facilities_for_people_with_disabilities">Зручності для осіб з обмеженими фізичними можливостями</label>
                                <input type="checkbox" name="other_facilities_for_people_with_disabilities" value="1" id="other_facilities_for_people_with_disabilities" class="hotel-features-list--item__checkbox--checkbox">
                            </li>
                        </ul>
                    </div>
                </div>

                <button type="submit" class="btn btn-first mt-4">
                    Зберегти
                </button>
            </form>
        </div>
    </div>
@endsection
