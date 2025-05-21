function decodeJWT(token) {
  if (!token) return null;

  try {
    const payloadBase64 = token.split('.')[1];
    const payloadJson = atob(payloadBase64);
    const payload = JSON.parse(payloadJson);

    const { id, role } = payload;
    return { id, role };
  } catch (error) {
    console.error('Failed to decode JWT:', error);
    return null;
  }
}
