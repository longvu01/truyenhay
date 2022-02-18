export const timeout = function (sec) {
  return new Promise((_, reject) =>
    setTimeout(() => reject(new Error('Request took too long!')), sec * 1000)
  );
};
//
export const AJAX = async function (url, uploadData = undefined) {
  try {
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(uploadData),
    };
    const fetchPro = uploadData ? fetch(url, options) : fetch(url);

    const res = await Promise.race([fetchPro, timeout(5)]);
    const data = await res.json();

    if (!res.ok) throw new Error(`${res.statusText}, ${data.status}`);

    return data;
  } catch (err) {
    throw err;
  }
};
