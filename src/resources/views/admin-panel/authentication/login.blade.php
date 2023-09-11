<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Login in Admin Panel</title>
</head>

<body class="bg-[#1e293b]">
    <div class="container mx-auto text-center m-8 font text-lg font-bold">Components</div>
    <div class="w-full divide-y border"></div>

    <div class="container mx-auto">
        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Buttons</div>
        <div class="flex">
            <div class="btn mr-2">
                <span class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="vuesax/broken/additem">
                            <g id="additem">
                                <path id="Vector" d="M2 5.43C2 3.14 3.14 2 5.43 2H10C12.29 2 13.43 3.14 13.43 5.43"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_2" d="M8 16H5.43C3.14 16 2 14.86 2 12.57V9.98001" stroke="white"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_3"
                                    d="M18.5701 22H14.0001C11.7101 22 10.5701 20.86 10.5701 18.57V11.43C10.5701 9.14 11.7101 8 14.0001 8H18.5701C20.8601 8 22.0001 9.14 22.0001 11.43V18.57C22.0001 20.86 20.8601 22 18.5701 22Z"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_4" d="M14.8701 15H18.1301" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_5" d="M16.5 16.63V13.37" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </g>
                    </svg>
                </span>
                Добавить
            </div>
            <div class="btn bg-red mr-2">
                <span class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="vuesax/broken/message-edit">
                            <g id="message-edit">
                                <path id="Vector"
                                    d="M22 8C22 4 20 2 16 2H8C4 2 2 4 2 8V21C2 21.55 2.45 22 3 22H16C20 22 22 20 22 16V12"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <g id="Group">
                                    <path id="Vector_2"
                                        d="M15.51 11.74L16.16 11.09C16.2 11.05 16.24 11.01 16.28 10.96C17.09 10.1 17.41 9.08999 16.16 7.83999C14.84 6.51999 13.8 6.94999 12.91 7.83999L7.72004 13.03C7.52004 13.23 7.33004 13.62 7.29004 13.9L7.01004 15.88C6.91004 16.6 7.41004 17.1 8.13004 17L10.11 16.72C10.39 16.68 10.78 16.49 10.98 16.29L12.92 14.35"
                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path id="Vector_3" d="M12.1699 8.57999C12.6099 10.15 13.8399 11.39 15.4199 11.83"
                                        stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </span>
                Изменить
            </div>
            <div class="btn bg-green mr-2">
                <span class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <g id="vuesax/broken/additem">
                            <g id="additem">
                                <path id="Vector" d="M2 5.43C2 3.14 3.14 2 5.43 2H10C12.29 2 13.43 3.14 13.43 5.43"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_2" d="M8 16H5.43C3.14 16 2 14.86 2 12.57V9.98001" stroke="white"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_3"
                                    d="M18.5701 22H14.0001C11.7101 22 10.5701 20.86 10.5701 18.57V11.43C10.5701 9.14 11.7101 8 14.0001 8H18.5701C20.8601 8 22.0001 9.14 22.0001 11.43V18.57C22.0001 20.86 20.8601 22 18.5701 22Z"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path id="Vector_4" d="M14.8701 15H18.1301" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                                <path id="Vector_5" d="M16.5 16.63V13.37" stroke="white" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </g>
                    </svg>
                </span>
                Добавить
            </div>
        </div>
        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Links</div>
        <div class="flex">
            <a href="#" class="link mr-2">page</a>
        </div>
        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Cards</div>
        <div class="flex">
            <div class="statistics-card mr-4">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96"
                        fill="none">
                        <path
                            d="M72.0004 28.64C71.7604 28.6 71.4804 28.6 71.2404 28.64C65.7204 28.44 61.3204 23.92 61.3204 18.32C61.3204 12.6 65.9204 8 71.6404 8C77.3604 8 81.9604 12.64 81.9604 18.32C81.9204 23.92 77.5204 28.44 72.0004 28.64Z"
                            stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M67.8816 57.7608C73.3616 58.6808 79.4016 57.7208 83.6416 54.8808C89.2816 51.1208 89.2816 44.9608 83.6416 41.2008C79.3616 38.3606 73.2416 37.4006 67.7616 38.3606"
                            stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M23.8819 28.64C24.1219 28.6 24.4019 28.6 24.6419 28.64C30.1619 28.44 34.5619 23.92 34.5619 18.32C34.5619 12.6 29.9619 8 24.2419 8C18.5219 8 13.9219 12.64 13.9219 18.32C13.9619 23.92 18.3619 28.44 23.8819 28.64Z"
                            stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M28.0017 57.7608C22.5217 58.6808 16.4817 57.7208 12.2417 54.8808C6.60172 51.1208 6.60172 44.9608 12.2417 41.2008C16.5217 38.3606 22.6417 37.4006 28.1217 38.3606"
                            stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M48.0004 58.5208C47.7604 58.4808 47.4804 58.4808 47.2404 58.5208C41.7204 58.3208 37.3203 53.8008 37.3203 48.2008C37.3203 42.4808 41.9204 37.8808 47.6404 37.8808C53.3604 37.8808 57.9604 42.5208 57.9604 48.2008C57.9204 53.8008 53.5204 58.3608 48.0004 58.5208Z"
                            stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        <path
                            d="M59.6388 71.1216C53.2788 66.8816 42.7588 66.8816 36.3589 71.1216C30.7189 74.8816 30.7189 81.0412 36.3589 84.8012C42.7588 89.0812 53.2388 89.0812 59.6388 84.8012"
                            stroke="#9900FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="value">
                    154 545
                </div>
                <div class="name">
                    посетителей
                </div>
            </div>
            <div class="statistics-card">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 96 96"
                        fill="none">
                        <path
                            d="M19 55.88C18.44 62.4 23.6 68 30.16 68H72.76C78.52 68 83.56 63.2801 84 57.5601L86.16 27.5601C86.64 20.9201 81.6 15.52 74.92 15.52H23.28"
                            stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M8 8H14.96C19.28 8 22.68 11.72 22.32 16L20.32 40.2" stroke="#9900FF"
                            stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M65 88C67.7614 88 70 85.7614 70 83C70 80.2386 67.7614 78 65 78C62.2386 78 60 80.2386 60 83C60 85.7614 62.2386 88 65 88Z"
                            stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path
                            d="M33 88C35.7614 88 38 85.7614 38 83C38 80.2386 35.7614 78 33 78C30.2386 78 28 80.2386 28 83C28 85.7614 30.2386 88 33 88Z"
                            stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path d="M36 32H84" stroke="#9900FF" stroke-width="1.5" stroke-miterlimit="10"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="value">
                    5 104
                </div>
                <div class="name">
                    товара
                </div>
            </div>
        </div>
        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Badge</div>
        <div class="flex flex-col items-start">
            <div class="badge mb-3">
                text
                <div class="value">2</div>
            </div>
            <div class="badge mb-3">
                text
                <div class="value">20</div>
            </div>
            <div class="badge">
                text
                <div class="value">+99</div>
            </div>
        </div>
        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Input</div>
        <div class="flex">
            <input type="text" class="input mr-4" placeholder="Email">
            <input type="text" class="input" placeholder="Password">
        </div>

        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Input group</div>
        <div class="flex">
            <div class="input-group">
                <label for="email" class="label">
                    Label
                </label>
                <input id="email" type="text" class="input" placeholder="Email">
            </div>
        </div>

        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Table</div>
        <div class="flex">
            <div class="table-container">
                <table class="table border-collapse">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>City</th>
                            <th>Badge</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="">Indiana</td>
                            <td class="">Indianapolis</td>
                            <td class="flex">
                                <div class="badge-table new mr-2">
                                    NEW
                                </div>
                                <div class="badge-table hit">
                                    HIT
                                </div>
                            </td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <td class="">Ohio</td>
                            <td class="">Columbus</td>
                            <td class="">Indianapolis</td>
                        </tr>
                        <tr>
                            <td class="">Michigan</td>
                            <td class="">Detroit</td>
                            <td class=""></td>

                        </tr>
                    </tbody>
                </table>
                <div class="pagination mt-3">
                    <div class="item">
                        1
                    </div>
                    <div class="item">
                        2
                    </div>
                    <div class="item">
                        3
                    </div>
                    <div class="item">
                        4
                    </div>
                    <div class="item">
                        5
                    </div>
                    <div class="item">
                        6
                    </div>
                    <div class="item">
                        7
                    </div>
                    <div class="item">
                        8
                    </div>
                    <div class="item">
                        9
                    </div>
                    <div class="item">
                        10
                    </div>
                </div>
            </div>
        </div>

        <div class="text-md m-5 text-theme-blue ml-0 font-bold">Pagination</div>
        <div class="flex">
            <div class="pagination">
                <div class="item">
                    1
                </div>
                <div class="item">
                    2
                </div>
                <div class="item">
                    3
                </div>
                <div class="item">
                    4
                </div>
                <div class="item">
                    5
                </div>
                <div class="item">
                    6
                </div>
                <div class="item">
                    7
                </div>
                <div class="item">
                    8
                </div>
                <div class="item">
                    9
                </div>
                <div class="item">
                    10
                </div>
            </div>
        </div>
        <div class="flex mt-5">
            <div class="pagination">
                <div class="item">
                    1
                </div>
                <div class="item">
                    2
                </div>
                <div class="item">
                    3
                </div>
                <div class="item">
                    4
                </div>
                <div class="item">
                    5
                </div>
                <div class="item">
                    6
                </div>
                <div class="item">
                    7
                </div>
                <div class="item">
                    8
                </div>
                <div class="item">
                    ...
                </div>
                <div class="item">
                    50
                </div>
            </div>
        </div>
    </div>
</body>

</html>
