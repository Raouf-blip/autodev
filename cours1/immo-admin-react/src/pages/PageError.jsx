import { useRouteError } from 'react-router-dom'

export default function PageError() {
  const error = useRouteError()
  return <>
    <h1>Une erreur est survenu</h1>
    <p>{error?.error?.toString() ?? error?.toString()}</p>
  </>
}