import React from 'react';
import { Link, Head } from '@inertiajs/inertia-react';

export default function Hello(props) {
    return (
        <>
            <Head title="Hello" />
            <div>
              <input type="text" /> <button type="button">Search</button>
            </div>

            <ul>
              <li></li>
            </ul>
        </>
    );
}
