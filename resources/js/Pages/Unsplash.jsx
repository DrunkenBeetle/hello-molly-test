import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link, Head } from '@inertiajs/inertia-react';

export default function Unsplash(props) {
  const [search, setSearch] = useState('');
  const [disabledFlag, setDisabledFlag] = useState(true);
  const [items, setItems] = useState([]);

  /**
   * Define an abort controller here so we can bail out. Really not needed
   * as we're just a single component and we're only searching when they click
   * the button, but here anyway
   */
  const abortController = new AbortController();

  useEffect(() => {
    setDisabledFlag(search.trim() === '')
  
    return () => {
      abortController.abort();
    };
  }, [search]);

  const doSearch = async () => {
    if (disabledFlag) {
      return;
    }

    setDisabledFlag(true);
    
    try {
      const rtn = await axios.post('api/search', { search }, { signal: abortController.signal });
      setItems(rtn.data);
    } catch (e) {

      /**
       * Tell someone about it. Who? I've no idea
       */
      console.error(e);
    }

    setDisabledFlag(false);
  }

  return (
    <>
      <Head title="Unsplash" />
      <div>
        <p>Search for something</p>
        <input type="text" value={search} onChange={(e) => (setSearch(e.target.value))} />
        <button type="button" disabled={disabledFlag} onClick={doSearch}>Search</button>
      </div>

      <ul>
        { items.map(x => (<li key={x.unsplash_api_id}><img src={x.thumbnail_url} /></li>) )}
      </ul>
    </>
  );
}
