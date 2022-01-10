---
title: Integrasi React dengan Laravolt
description: Cara menambahkan halaman yang butuh React 
extends: _layouts.documentation 
section: content
---

# Integrasi React ke Laravolt

1. Install babel preset react

```
npm i @babel/preset-react
```

2. Buat file `react.js` di dalam folder `resource/js`

```js
import ReactDOM from "react-dom";
import React from "react";
import ReactIndex from "./react/ReactIndex";

ReactDOM.render(
    <React.StrictMode>
        <ReactIndex />
    </React.StrictMode>,
    document.getElementById('reactContainer')
)
```
3. 
4. Tambahkan laravel mix untuk react pada file `webpack.mix.js`

```js
mix.js('resources/js/react.js', 'public/js')
```


6. Buat folder baru untuk komponen react dalam folder `resource/js`. Berikut adalah struktur foldernya.

- resource
    - js
        - react
            - component
                - QuoteOfTheDay.js
            - ReactIndex.js
        - react.js

7. Konfigurasi komponen

```
import React from 'react';
import {useState, useEffect} from 'react';
import axios from "axios";

const QuoteOfTheDay = () => {
    const [quote, setQuote] = useState('');

    useEffect(() => {
        axios
            .get("https://quotes.rest/qod")
            .then(response => {
                setQuote(response.data.contents.quotes[0].quote);
                console.log(response);
            });
    }, []);

    return(
        <div>{quote}</div>
    );
};

export default QuoteOfTheDay;
```

8. Konfigurasi routesnya

```
import React from 'react';
import {BrowserRouter as Router, Route, Routes} from "react-router-dom";
import QuoteOfTheDay from './components/QuoteOfTheDay';

const ReactIndex = () => {
    return (
        <Router>
            <Routes>
                <Route path="/integration/react" exact element={<QuoteOfTheDay />} />
            </Routes>
        </Router>
    );
};

export default ReactIndex;
```

9. Arahkan route yang ada pada file `resource/view/integration/react` menuju root file react yang ada di `resouce/js`

```
<x-volt-app title="Sample React Component">
    <div id="reactContainer"></div>

    @push('script')
        <script src="{{asset('js/reactjs.js')}}" defer></script>
    @endpush
</x-volt-app>
```

10. Jalankan laravel mix

```
npm run dev
```

Halaman yang berisi React component sudah siap diakses.
